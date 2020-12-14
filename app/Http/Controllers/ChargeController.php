<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\User;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view_data = 
        [
            'title' => 'Pagos',
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
            'metodo' => ['required'],
            'repartidor' => ['required'],
            'pedido' => ['required'],
            'negocio' => ['required'],
        ]);


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
}
