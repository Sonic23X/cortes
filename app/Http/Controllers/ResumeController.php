<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Place;
use App\Models\History;
use App\Models\Payment;
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
            
            $pedidos_cobrados = Payment::getAmountPerCourier($courier->id);
            $pagos_a_urbo = AccountMovement::paymentsToUrbo($courier->id);
            $pagos_a_repartidor = AccountMovement::paymentsToCourier($courier->id);
            $cortes = History::historyPerCourier($courier->id);

            $saldo = $pedidos_cobrados + $cortes - $pagos_a_urbo - $pagos_a_repartidor;

            return [
                $courier->id,
                $courier->name . ' ' . $courier->last_name,
                $pedidos_cobrados,
                $pagos_a_urbo,
                $pagos_a_repartidor,
                $cortes,
                $saldo,
            ];
        });

        $view_data = 
        [
            'title' => 'Resumen',
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

    public function detallesPagosUrbo($id)
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

    public function detallesPagosRepartidor($id)
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
}
