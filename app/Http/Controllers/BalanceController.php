<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Madero;
use App\Models\User;

class BalanceController extends Controller
{
    private $filter = '';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Madero::all();

        $payments_map = $payments->map(function($payment) 
        {
            
            $courier = User::where('id', $payment->id_courier)->first();

            $total = $payment->amount_madero + $payment->amount_repartos;
            $total -= $payment->amount_urbo;
            $total += $payment->amount_repartidor;

            return [
                $payment->id,
                $courier->name . ' ' . $courier->last_name,
                $payment->amount_madero,
                $payment->amount_repartos,
                $payment->amount_urbo,
                $payment->amount_repartidor,
                $total,
            ];
        });

        $view_data = 
        [
            'title' => 'Resumen de Repartos Urbo',
            // Custom data of view
            'couriers' => User::typeCourier()->get(),
            'columns' => $payments_map,
        ];
        return view( 'balance.main_table', $view_data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view_data = 
        [
            'title' => 'Resumen de Repartos Urbo',
            // Custom data of view
            'couriers' => User::typeCourier()->get(),
        ];
        return view( 'balance.new_register', $view_data );
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
            'repartidor' => ['required'],
            'madero' => ['required'],
            'repartos' => ['required'],
            'urbo' => ['required'],
            'repartidor_monto' => ['required'],
        ]);

        $data = [
            'id_courier' => $request->get('repartidor'),
            'amount_madero' => $request->get('madero'),
            'amount_repartos' => $request->get('repartos'),
            'amount_urbo' => $request->get('urbo'),
            'amount_repartidor' => $request->get('repartidor_monto'),
        ];

        Madero::create($data);

        return redirect('/saldos');
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
        $view_data = 
        [
            'title' => 'Resumen de Repartos Urbo',
            // Custom data of view
            'couriers' => User::typeCourier()->get(),
            'movement' => Madero::find($id),
        ];
        return view( 'balance.update_register', $view_data );
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
            'repartidor' => ['required'],
            'madero' => ['required'],
            'repartos' => ['required'],
            'urbo' => ['required'],
            'repartidor_monto' => ['required'],
        ]);

        $data = [
            'id_courier' => $request->get('repartidor'),
            'amount_madero' => $request->get('madero'),
            'amount_repartos' => $request->get('repartos'),
            'amount_urbo' => $request->get('urbo'),
            'amount_repartidor' => $request->get('repartidor_monto'),
        ];

        Madero::where('id', $id)->update($data);

        return redirect('/saldos');
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

    public function filter(Request $request)
    {
        $payments = Madero::all();

        $this->filter = $request->get('filtro');

        $payments_map = $payments->map(function($payment) 
        {
            $courier = User::where('id', $payment->id_courier)->first();

            $total = $payment->amount_madero + $payment->amount_repartos;
            $total -= $payment->amount_urbo;
            $total += $payment->amount_repartidor;            

            if( $this->filter == 'true')
            {
                if ($courier->status == 1) 
                    return 
                    [
                        $payment->id,
                        $courier->name . ' ' . $courier->last_name,
                        $payment->amount_madero,
                        $payment->amount_repartos,
                        $payment->amount_urbo,
                        $payment->amount_repartidor,
                        $total,
                    ];
            }
            else
            {
                return 
                [
                    $payment->id,
                    $courier->name . ' ' . $courier->last_name,
                    $payment->amount_madero,
                    $payment->amount_repartos,
                    $payment->amount_urbo,
                    $payment->amount_repartidor,
                    $total,
                ];
            }
        });
        
        return response(['pagos' => $payments_map], 200);
    }
}
