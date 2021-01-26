<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Place;
use App\Models\History;
use App\Models\Account;
use App\Models\Payment;
use App\Models\Madero;
use App\Models\Retetion;
use App\Models\AccountMovement;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers = User::typeCourier()->get();

        $autocomplete = $couriers->map(function($courier) {
            
            return [
                $courier->id,
                $courier->name . ' ' . $courier->last_name,
            ];
        });

        $tableColumns = $couriers->map(function($courier) {

            $retencion_repartidor = Retetion::where('id_courier', $courier->id)->sum('amount');
            
            $pedidos_cobrados = Payment::getAmountPerCourier($courier->id);
            $pagos_a_urbo = ( AccountMovement::paymentsToUrbo($courier->id) + $retencion_repartidor);
            $pagos_a_repartidor = AccountMovement::paymentsToCourier($courier->id);
            
            $maderos = Madero::where('id_courier', $courier->id)->first();
            $maderos_total = 0;
            if ($maderos != null)
                $maderos_total = $maderos->amount_madero + $maderos->amount_repartos - $maderos->amount_urbo + $maderos->amount_repartidor;

            $cortes = History::historyPerCourier($courier->id);

            $saldo = $maderos_total + $pedidos_cobrados + $cortes - $pagos_a_urbo - $pagos_a_repartidor;

            return [
                $courier->id,
                $courier->name . ' ' . $courier->last_name,
                $maderos_total,
                $pedidos_cobrados,
                $pagos_a_urbo,
                $pagos_a_repartidor,
                $cortes,
                $saldo,
            ];
        });

        $view_data = 
        [
            'title' => 'Resumen general',
            'couriers' => $autocomplete,
            'columns' => $tableColumns,
        ];

        return view('summary/summary_main_table', $view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function nuevoCorte(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'repartidor' => ['required', 'numeric'],
            'monto' => ['required', 'numeric'],
        ]);

        $data = 
        [
            'id_courier' => $request->get('repartidor'),
            'name' => $request->get('nombre'),
            'amount' => $request->get('monto'),
        ];

        History::create($data);

        return response(['message' => '¡Corte registrado!'], 200);
    }

    public function detallesPagosCobrados($id)
    {
        $courier = User::find($id);

        $pedidos_cobrados = Payment::where('id_courier', $id)->get();

        $tableColumns = $pedidos_cobrados->map(function($pedido) 
        {
            $negocio = Place::find($pedido->id_place);

            return [
                $pedido->date,
                $pedido->id_order,
                $negocio->name,
                $pedido->amount,
            ];
        });

        $view_data = 
        [
            'title' => 'Usuarios',
            'courier' => $courier,
            'columns' => $tableColumns,
        ];

        return view( 'summary/summary_payment_courier_detail', $view_data );
    }

    public function detallesPagosCobradosFiltro(Request $request)
    {
        $request->validate([
            'fechaInicio' => [],
            'fechaFin' => [],
            'repartidor' => [],
        ]);

        $id = $request->get('repartidor');
        $pagos = null;

        if ($request->get('fechaInicio') != null && $request->get('fechaFin') == null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $pagos = Payment::where('id_courier', $id)->where('date', '>=', $fechaInicio)->get();
        }            
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )        
        {
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            $pagos = Payment::where('id_courier', $id)->where('date', '<=', $fechaFin)->get();
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            
            $pagos = Payment::where('id_courier', $id)->where('date', '>=', $fechaInicio)
                                        ->where('date', '<=', $fechaFin)
                                        ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            $pagos = Payment::where('id_courier', $id)->get();
        }

        $tableColumns = $pagos->map(function($pedido) 
        {
            $negocio = Place::find($pedido->id_place);

            return [
                $pedido->date,
                $pedido->id_order,
                $negocio->name,
                $pedido->amount,
            ];
        });

        return response(['pagos' => $tableColumns], 200);
    }

    public function detallesPagosUrbo($id)
    {
        $courier = User::find($id);

        $pagos_urbo = AccountMovement::where('id_courier', $id)->typeToUrbo()->get();

        $tableColumns = $pagos_urbo->map(function($pago_urbo) {

            $cuenta = Account::find($pago_urbo->id_account);

            return [
                $pago_urbo->id,
                $pago_urbo->date,
                $cuenta->name,
                $pago_urbo->amount
            ];
        });

        $view_data = 
        [
            'title' => 'Usuarios',
            'courier' => $courier,
            'columns' => $tableColumns,
        ];

        return view( 'summary/summary_payment_to_urbo_detail', $view_data );
    }

    public function detallesPagosUrboFiltro(Request $request)
    {
        $request->validate([
            'fechaInicio' => [],
            'fechaFin' => [],
            'repartidor' => [],
        ]);

        $id = $request->get('repartidor');
        $detalles = null;

        if ($request->get('fechaInicio') != null && $request->get('fechaFin') == null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $detalles = AccountMovement::where('id_courier', $id)->typeToUrbo()
                                        ->where('date', '>=', $fechaInicio)->get();
        }            
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )        
        {
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            $detalles = AccountMovement::where('id_courier', $id)->typeToUrbo()
                                        ->where('date', '<=', $fechaFin)->get();
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            
            $detalles = AccountMovement::where('id_courier', $id)->typeToUrbo()
                                        ->where('date', '>=', $fechaInicio)
                                        ->where('date', '<=', $fechaFin)
                                        ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            $detalles = AccountMovement::where('id_courier', $id)->typeToUrbo()->get();
        }

        $tableColumns = $detalles->map(function($pago_urbo) {

            $cuenta = Account::find($pago_urbo->id_account);

            return [
                $pago_urbo->id,
                $pago_urbo->date,
                $cuenta->name,
                $pago_urbo->amount
            ];
        });

        return response(['detalles' => $tableColumns], 200);
    }

    public function detallesPagosRepartidor($id)
    {
        $courier = User::find($id);

        $pagos_repartidor = AccountMovement::where('id_courier', $id)->typeToCourier()->get();

        $view_data = 
        [
            'title' => 'Usuarios',
            'courier' => $courier,
            'columns' => $pagos_repartidor,
        ];

        return view( 'summary/summary_payment_to_courier_detail', $view_data );
    }

    public function detallesPagosRepartidorFiltro(Request $request)
    {
        $request->validate([
            'fechaInicio' => [],
            'fechaFin' => [],
            'repartidor' => [],
        ]);

        $id = $request->get('repartidor');
        $detalles = null;

        if ($request->get('fechaInicio') != null && $request->get('fechaFin') == null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $detalles = AccountMovement::where('id_courier', $id)->typeToCourier()
                                        ->where('date', '>=', $fechaInicio)->get();
        }            
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )        
        {
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            $detalles = AccountMovement::where('id_courier', $id)->typeToCourier()
                                        ->where('date', '<=', $fechaFin)->get();
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            
            $detalles = AccountMovement::where('id_courier', $id)->typeToCourier()
                                        ->where('date', '>=', $fechaInicio)
                                        ->where('date', '<=', $fechaFin)
                                        ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            $detalles = AccountMovement::where('id_courier', $id)->typeToCourier()->get();
        }

        return response(['detalles' => $detalles], 200);
    }

    public function detallesCortes($id)
    {
        $courier = User::find($id);

        $cortes = History::where('id_courier', $id)->get();

        $view_data = 
        [
            'title' => 'Usuarios',
            'courier' => $courier,
            'cortes' => $cortes,
        ];

        return view( 'summary/summary_cuts_detail', $view_data );
    }

    public function detallesCortesFiltro(Request $request)
    {
        $request->validate([
            'fechaInicio' => [],
            'fechaFin' => [],
            'repartidor' => [],
        ]);

        $id = $request->get('repartidor');
        $cortes = null;

        if ($request->get('fechaInicio') != null && $request->get('fechaFin') == null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $cortes = History::where('id_courier', $id)->where('created_at', '>=', $fechaInicio)->get();
        }            
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )        
        {
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            $cortes = History::where('id_courier', $id)->where('created_at', '<=', $fechaFin)->get();
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            
            $cortes = History::where('id_courier', $id)
                            ->where('created_at', '>=', $fechaInicio)
                            ->where('created_at', '<=', $fechaFin)
                            ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            $cortes = History::where('id_courier', $id)->get();
        }       

        return response(['cortes' => $cortes], 200);
    }

    public function updateCorteName(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'id' => ['required'],
        ]);
        
        $data = 
        [
            'name' => $request->get('nombre'),
        ];      

        History::where('id', $request->get('id'))->update($data);

        return response(['message' => '¡Corte actualizado!'], 200);
    }

    public function updateCorteMonto(Request $request)
    {
        $request->validate([
            'contrasena' => ['required'],
            'monto' => ['required'],
            'id' => ['required'],
        ]);

        if ($request->get('contrasena') == '0soNv75!') 
        {
        
            $data = 
            [
                'amount' => $request->get('monto'),
            ];      

            History::where('id', $request->get('id'))->update($data);

            return response(['message' => '¡Corte actualizado!'], 200);
        }
        else
            return response(['message' => '¡La contraseña es incorrecta!'], 401);
    }

    public function deleteCorte($id)
    {
        History::where('id', $id)->delete();

        return response(['message' => '¡Corte eliminado!'], 200);
    }


}
