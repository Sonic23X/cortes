<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retetion;
use App\Models\User;

class RetentionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retentions = Retetion::all();

        $retentions_map = $retentions->map(function($retention) {
            
            $courier = User::where('id', $retention->id_courier)->first();

            return [
                $retention->id,
                $courier->name . ' ' . $courier->last_name,
                $retention->date,
                $retention->amount,
                $retention->id_order,
            ];
        });

        $view_data = 
        [
            'title' => 'Resumen de Retenciones',
            // Custom data of view
            'columns' => $retentions_map,
        ];
        return view( 'retentions/main_table', $view_data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couriers = User::typeCourier()->get();

        $autocomplete = $couriers->map(function($courier) {
            
            return [
                $courier->id,
                $courier->name . ' ' . $courier->last_name,
            ];
        });

        $view_data = 
        [
            'title' => 'Nueva retencion',
            'couriers' => $autocomplete,
        ];
        return view('retentions/new_register', $view_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => ['required'],
            'monto' => ['required'],
            'repartidor' => ['required'],
            'pedido' => ['required'],
        ]);

        $data = [
            'date' => $request->get('fecha'),
            'id_order' => $request->get('pedido'),
            'id_courier' => $request->get('repartidor'),
            'amount' => $request->get('monto'),
        ];

        Retetion::create($data);

        return redirect('/retenciones');
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
        $couriers = User::typeCourier()->get();

        $view_data = 
        [
            'title' => 'Actualizar retencion',
            'couriers' => $couriers,
            'movement' => Retetion::find($id),
        ];
        return view('retentions/update_register', $view_data);
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
        $request->validate([
            'fecha' => ['required'],
            'monto' => ['required'],
            'repartidor' => ['required'],
            'pedido' => ['required'],
        ]);

        $data = [
            'date' => $request->get('fecha'),
            'id_order' => $request->get('pedido'),
            'id_courier' => $request->get('repartidor'),
            'amount' => $request->get('monto'),
        ];

        Retetion::where('id', $id)->update($data);

        return redirect('/retenciones');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Retetion::where('id', $id)->delete();
        return response(['message' => '¡Registro eliminado con exito!'], 200);
    }
}
