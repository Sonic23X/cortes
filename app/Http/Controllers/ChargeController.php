<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\User;
use App\Models\Payment;
use App\Models\Concept;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $payments = Payment::all();

        $payments_map = $payments->map(function($payment) {
            
            $courier = User::where('id', $payment->id_courier)->first();
            $place = Place::where('id', $payment->id_place)->first();

            return [
                $payment->id,
                $payment->date,
                $payment->id_order,
                $courier->name . ' ' . $courier->last_name,
                $payment->amount,
                $place->name,
                $payment->type,
            ];
        });

        $view_data = 
        [
            'title' => 'Pagos',
            'payments' => $payments_map,
        ];
        return view('courierPayment/payment_main_table', $view_data);
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

        $places = Place::all();

        $place_map = $places->map(function($place) {
            
            return [
                $place->id,
                $place->name 
            ];
        });

        $view_data = 
        [
            'title' => 'Pagos',
            'couriers' => $autocomplete,
            'places' => $place_map,
        ];
        return view('courierPayment/payment_new_register', $view_data);
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
            'negocio' => ['required'],
        ]);

        $data = [
            'date' => $request->get('fecha'),
            'id_order' => $request->get('pedido'),
            'id_courier' => $request->get('repartidor'),
            'amount' => $request->get('monto'),
            'id_place' => $request->get('negocio'),
        ];

        Payment::create($data);

        return redirect('/pagos');
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

    public function updateMonto(Request $request)
    {
        $request->validate([
            'monto' => ['required', 'numeric'],
            'id' => ['required'],
        ]);

        $data = 
        [
            'amount' => $request->get('monto'),
        ];      

        Payment::where('id', $request->get('id'))->update($data);

        return response(['message' => '¡Monto actualizado!'], 200);
    }
}
