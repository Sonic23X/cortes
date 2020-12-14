<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\History;

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

        $view_data = 
        [
            'title' => 'Resumen',
            'couriers' => $autocomplete,
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
}
