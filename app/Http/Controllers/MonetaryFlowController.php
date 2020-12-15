<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountMovement;
use App\Models\Account;
use App\Models\Concept;
use App\Models\User;

class MonetaryFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movements = AccountMovement::all();

        $tableColumns = $movements->map(function($movement) {

            $concept = Concept::find($movement->concept);
            $account = Account::find($movement->id_account);
            $charge = '-';
            $payment = '-';

            if($movement->type == AccountMovement::TYPE_CHARGE)
                $charge = '$' . $movement->amount;
            if($movement->type == AccountMovement::TYPE_PAYMENT)
                $payment = '$' . $movement->amount;

            return [
                $concept->concept,
                $movement->details,
                $account->name,
                $movement->date,
                $charge,
                $payment,
                $movement->balance,
            ];
        });

        $view_data = 
        [
            'title' => 'Flujo financiero',
            // Custom data of view
            'accounts' => Account::all(),
            'movements' => $tableColumns,
        ];
        return view( 'flow.main_table', $view_data );
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
            'title' => 'Dashboard',
            'couriers' => $autocomplete,
            'concepts' => Concept::all(),
            'accounts' => Account::all(),
        ];
        return view( 'flow.new_register', $view_data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errorMessages = [
            'cantidad.required' => 'Ingrese la cantidad a registrar',
            'detalle.required' => 'Ingrese los detalles del registro',
            'fecha.required' => 'Ingrese la fecha del registro',
        ];

        $validatedData = $request->validate([
            'cantidad' => ['required', 'numeric'],
            'concepto' => ['required', 'numeric', 'min:1', 'max:10'],
            'detalle' => ['required'],
            'cuenta' => ['required', 'numeric', 'min:1', 'max:10'],
            'fecha' => ['required', 'date'],
            'tipo' => ['required', 'numeric'],
            'repartidor' => [],
        ], $errorMessages);

        $data = null;
        $data_courier = null;
        $balance = 0;
        $account = Account::find($request->get('cuenta'));

        // Get head of selected concept
        $concept = Concept::where('id', $request->get('concepto'))->first();

        switch ($concept->heading) 
        {
            case 1:
                $balance = $account->amount - $request->get('cantidad');

                $data = 
                [
                    'concept' => $request->get('concepto'),
                    'details' => $request->get('detalle'),
                    'id_account' => $request->get('cuenta'),
                    'date' => $request->get('fecha'),
                    'type' => ($request->get('tipo') == 1) ? AccountMovement::TYPE_CHARGE : AccountMovement::TYPE_PAYMENT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                    'id_courier' => $request->get('repartidor')
                ];

                break;
            case 2:
                $balance = $account->amount + $request->get('cantidad');

                $data = 
                [
                    'concept' => $request->get('concepto'),
                    'details' => $request->get('detalle'),
                    'id_account' => $request->get('cuenta'),
                    'date' => $request->get('fecha'),
                    'type' => ($request->get('tipo') == 1) ? AccountMovement::TYPE_CHARGE : AccountMovement::TYPE_PAYMENT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                    'id_courier' => $request->get('repartidor')
                ];

                break;
            case 3:
                $balance = ( $request->get('tipo') == 1 ) ? $account->amount - $request->get('cantidad') : $account->amount + $request->get('cantidad');

                $data = 
                [
                    'concept' => $request->get('concepto'),
                    'details' => $request->get('detalle'),
                    'id_account' => $request->get('cuenta'),
                    'date' => $request->get('fecha'),
                    'type' => ($request->get('tipo') == 1) ? AccountMovement::TYPE_CHARGE : AccountMovement::TYPE_PAYMENT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                    'id_courier' => null,
                ];
                
                break;
        }

        // Crear registro en flujo
        AccountMovement::create($data);

        // Actualizamos la cuenta
        Account::updateAmount($request->get('cuenta'), $balance);

        // Si data courier es null, significa que no hay registro que tenga que ver con repartidor


        return redirect('/flujo');
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
        
    }

    public function dateFilterTable(Request $request)
    {
        $request->validate([
            'fechaInicio' => [],
            'fechaFin' => [],
        ]);

        $movements = null;

        if ($request->get('fechaInicio') != null && $request->get('fechaFin') == null ) 
        {
            $movements = AccountMovement::where('date', '>=', $request->get('fechaInicio'))->get();

            return response(['movements' => $movements], 200);
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )
        {
            $movements = AccountMovement::where('date', '<=', $request->get('fechaFin'))->get();

            return response(['movements' => $movements], 200);
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $movements = AccountMovement::where('date', '>=', $request->get('fechaInicio'))
                                        ->where('date', '<=', $request->get('fechaFin'))
                                        ->get();

            return response(['movements' => $movements], 200);
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            return response(['movements' => AccountMovement::all()], 200);
        }
    }

}
