<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountMovement;
use App\Models\Account;
use App\Models\Concept;
use App\Models\User;

class MonetaryFlowController extends Controller
{

    private $global_balance;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $global_balance = 0;
        $movements = AccountMovement::orderBy('date', 'asc')->get();

        $tableColumns = $movements->map(function($movement) {

            $concept = Concept::find($movement->concept);
            $account = Account::find($movement->id_account);
            $charge = '-';
            $payment = '-';

            if($movement->type == AccountMovement::TYPE_CHARGE)
            {
                $charge = '$' . $movement->amount;
                $this->global_balance -= $movement->amount;
            }
            if($movement->type == AccountMovement::TYPE_PAYMENT)
            {
                $payment = '$' . $movement->amount;
                $this->global_balance += $movement->amount;
            }

            return [
                $concept->concept,
                $movement->details,
                $account->name,
                $movement->date,
                $charge,
                $payment,
                $this->global_balance,
                $movement->id,
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
            'fecha.required' => 'Ingrese la fecha del registro',
        ];

        $validatedData = $request->validate([
            'cantidad' => ['required', 'numeric'],
            'concepto' => ['required', 'numeric'],
            'detalle' => [],
            'cuenta' => ['required', 'numeric'],
            'fecha' => ['required'],
            'tipo' => ['required', 'numeric'],
            'repartidor' => [],
        ], $errorMessages);

        $fechaRequest = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', str_replace('T', ' ', $request->get('fecha')) );

        $data = null;
        $data_courier = null;
        $balance = 0;
        $account = Account::find($request->get('cuenta'));

        // Get head of selected concept
        $concept = Concept::where('id', $request->get('concepto'))->first();

        // Get the last register of the date
        $last_row = AccountMovement::where('date', '<=', $fechaRequest)
                                   ->where('id_account', $request->get('cuenta'))
                                   ->orderBy('date', 'desc')
                                   ->first();

        if ($last_row != null)
            $last_row = $last_row->balance;
        else
            $last_row = $account->amount;

        switch ($concept->heading)
        {
            case 1:
                $balance = $last_row - $request->get('cantidad');
                $data =
                [
                    'concept' => $request->get('concepto'),
                    'details' => $request->get('detalle'),
                    'id_account' => $request->get('cuenta'),
                    'date' => $fechaRequest,
                    'type' => AccountMovement::TYPE_CHARGE,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                    'id_courier' => $request->get('repartidor')
                ];
                break;
            case 2:
                $balance = $last_row + $request->get('cantidad');
                $data =
                [
                    'concept' => $request->get('concepto'),
                    'details' => $request->get('detalle'),
                    'id_account' => $request->get('cuenta'),
                    'date' => $fechaRequest,
                    'type' => AccountMovement::TYPE_PAYMENT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                    'id_courier' => $request->get('repartidor')
                ];
                break;
            case 3:
                $balance = ( $request->get('tipo') == 1 ) ? $last_row - $request->get('cantidad') : $last_row + $request->get('cantidad');
                $data =
                [
                    'concept' => $request->get('concepto'),
                    'details' => $request->get('detalle'),
                    'id_account' => $request->get('cuenta'),
                    'date' => $fechaRequest,
                    'type' => ($request->get('tipo') == 1) ? AccountMovement::TYPE_CHARGE : AccountMovement::TYPE_PAYMENT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                    'id_courier' => null,
                ];
                break;
        }

        // Crear registro en flujo
        $actual_movement = AccountMovement::create($data);

        // Actualizamos el resto de registros posteriores a esa fecha
        $last_balance = 0;
        $post_rows = AccountMovement::where('date', '>=', $fechaRequest)
                                    ->where('id_account', $request->get('cuenta'))
                                    ->where('id', '!=', $actual_movement->id)
                                    ->orderBy('date', 'asc')
                                    ->get();

        foreach ($post_rows as $row)
        {
            $last_balance = ( $row->type == AccountMovement::TYPE_CHARGE ) ? $balance - $row->amount : $balance + $row->amount;

            $data = [
                'balance' => $last_balance,
            ];

            AccountMovement::where('id', $row->id)->update($data);
            $balance = $last_balance;
        }

        // Actualizamos la cuenta
        if ($last_balance == 0) {
            $last_balance = $balance;
        }
        Account::updateAmount($request->get('cuenta'), $last_balance);

        return redirect('/flujo');
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
            'movement' => AccountMovement::find($id),
        ];
        return view( 'flow.update_register', $view_data );
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
        $errorMessages = [
            'cantidad.required' => 'Ingrese la cantidad a registrar',
            'fecha.required' => 'Ingrese la fecha del registro',
        ];

        $validatedData = $request->validate([
            'cantidad' => ['required', 'numeric'],
            'concepto' => ['required', 'numeric'],
            'detalle' => [],
            'cuenta' => ['required', 'numeric'],
            'fecha' => ['required'],
            'tipo' => ['required', 'numeric'],
            'repartidor' => [],
        ], $errorMessages);

        // Tomar movimiento antes de actualización
        $movement = AccountMovement::find($id);
        $fechaRequest = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', str_replace('T', ' ', $request->get('fecha')) );
        $data = null;
        $data_courier = null;
        $balance = 0;

        //Validar que el proceso sea bajo la misma cuenta
        if ($movement->id_account != $request->get('cuenta')) {
            //Quitamos el movimiento de la cuenta anterior
            $previous_account = Account::find($movement->id_account);

            $last_row = AccountMovement::where('date', '<', $movement->date)
                                        ->where('id_account', $previous_account->id)
                                        ->orderBy('date', 'desc')
                                        ->select('id','type', 'amount', 'balance')
                                        ->first();

            $new_balance = ( $last_row != NULL ) ? $last_row->amount : 0;

            $post_rows = AccountMovement::where('date', '>', $movement->date)
                                        ->where('id_account', $previous_account->id)
                                        ->orderBy('date', 'asc')
                                        ->get();

            foreach ($post_rows as $row) {
                $last_balance = ( $row->type == AccountMovement::TYPE_CHARGE ) ? $new_balance - $row->amount : $new_balance + $row->amount;
                $data = [
                    'balance' => $last_balance,
                ];
                AccountMovement::where('id', $row->id)->update($data);
                $new_balance = $last_balance;
            }
            Account::updateAmount($previous_account->id, $last_balance);

            $concept = Concept::where('id', $request->get('concepto'))->first();
            $last_row = AccountMovement::where('date', '<', $fechaRequest)
                                       ->where('id_account', $request->get('cuenta'))
                                       ->orderBy('date', 'desc')
                                       ->first();

            if ($last_row != null)
                 $last_row = $last_row->balance;
            else
                 $last_row = 0;

            switch ($concept->heading)
            {
                case 1:
                    $balance = $last_row - $request->get('cantidad');

                    $data =
                    [
                       'concept' => $request->get('concepto'),
                       'details' => $request->get('detalle'),
                       'id_account' => $request->get('cuenta'),
                       'date' => $fechaRequest,
                       'type' => AccountMovement::TYPE_CHARGE,
                       'amount' => $request->get('cantidad'),
                       'balance' => $balance,
                       'id_courier' => $request->get('repartidor')
                    ];
                    break;
                 case 2:
                     $balance = $last_row + $request->get('cantidad');

                     $data =
                     [
                         'concept' => $request->get('concepto'),
                         'details' => $request->get('detalle'),
                         'id_account' => $request->get('cuenta'),
                         'date' => $fechaRequest,
                         'type' => AccountMovement::TYPE_PAYMENT,
                         'amount' => $request->get('cantidad'),
                         'balance' => $balance,
                         'id_courier' => $request->get('repartidor')
                     ];

                     break;
                 case 3:
                     $balance = ( $request->get('tipo') == 1 ) ? $last_row - $request->get('cantidad') : $last_row + $request->get('cantidad');

                     $data =
                     [
                         'concept' => $request->get('concepto'),
                         'details' => $request->get('detalle'),
                         'id_account' => $request->get('cuenta'),
                         'date' => $fechaRequest,
                         'type' => ($request->get('tipo') == 1) ? AccountMovement::TYPE_CHARGE : AccountMovement::TYPE_PAYMENT,
                         'amount' => $request->get('cantidad'),
                         'balance' => $balance,
                         'id_courier' => null,
                     ];

                     break;
            }

            // Actualizar registro en flujo
            AccountMovement::where('id', $id)->update($data);

            // Actualizamos el resto de registros posteriores a esa fecha
            $last_balance = 0;
            $post_rows = AccountMovement::where('date', '>', $fechaRequest)
                                        ->where('id_account', $request->get('cuenta'))
                                        ->where('id', '!=', $id)
                                        ->orderBy('date', 'asc')
                                        ->get();

            foreach ($post_rows as $row)
            {
                $last_balance = ( $row->type == AccountMovement::TYPE_CHARGE ) ? $balance - $row->amount : $balance + $row->amount;

                $data = [
                    'balance' => $last_balance,
                ];

                AccountMovement::where('id', $row->id)->update($data);
                $balance = $last_balance;
            }

            // Actualizamos la cuenta
            if ($last_balance == 0) {
                $last_balance = $balance;
            }
            Account::updateAmount($request->get('cuenta'), $last_balance);

        }
        else
        {
          $last_row = AccountMovement::where('date', '<', $fechaRequest)
                                      ->where('id_account', $request->get('cuenta'))
                                      ->orderBy('date', 'desc')
                                      ->select('id','type', 'amount', 'balance')
                                      ->first();

          if ($last_row != null)
              $balance = $last_row->balance;
          else
              $balance = 0;

          // Get head of selected concept
          $concept = Concept::where('id', $request->get('concepto'))->first();

          switch ($concept->heading)
          {
              case 1:
                  $balance -= $request->get('cantidad');

                  $data =
                  [
                      'concept' => $request->get('concepto'),
                      'details' => $request->get('detalle'),
                      'id_account' => $request->get('cuenta'),
                      'date' => $fechaRequest,
                      'type' => AccountMovement::TYPE_CHARGE,
                      'amount' => $request->get('cantidad'),
                      'balance' => $balance,
                      'id_courier' => $request->get('repartidor')
                  ];

                  break;
              case 2:
                  $balance += $request->get('cantidad');

                  $data =
                  [
                      'concept' => $request->get('concepto'),
                      'details' => $request->get('detalle'),
                      'id_account' => $request->get('cuenta'),
                      'date' => $fechaRequest,
                      'type' => AccountMovement::TYPE_PAYMENT,
                      'amount' => $request->get('cantidad'),
                      'balance' => $balance,
                      'id_courier' => $request->get('repartidor')
                  ];

                  break;
              case 3:
                  $balance = ( $request->get('tipo') == 1 ) ? $balance - $request->get('cantidad') : $balance + $request->get('cantidad');

                  $data =
                  [
                      'concept' => $request->get('concepto'),
                      'details' => $request->get('detalle'),
                      'id_account' => $request->get('cuenta'),
                      'date' => $fechaRequest,
                      'type' => ($request->get('tipo') == 1) ? AccountMovement::TYPE_CHARGE : AccountMovement::TYPE_PAYMENT,
                      'amount' => $request->get('cantidad'),
                      'balance' => $balance,
                      'id_courier' => null,
                  ];

                  break;
          }

          AccountMovement::where('id', $id)->update($data);

          //Actualizamos los siguientes registros
          $last_balance = 0;
          $post_rows = AccountMovement::where('date', '>=', $fechaRequest)
                                      ->where('id_account', $request->get('cuenta'))
                                      ->where('id', '!=', $id)
                                      ->orderBy('date', 'asc')
                                      ->get();

          foreach ($post_rows as $row)
          {
              $last_balance = ( $row->type == AccountMovement::TYPE_CHARGE ) ? $balance - $row->amount : $balance + $row->amount;

              $data = [
                  'balance' => $last_balance,
              ];

              AccountMovement::where('id', $row->id)->update($data);
              $balance = $last_balance;
          }

          // Actualizamos la cuenta
          if ($last_balance == 0) {
              $last_balance = $balance;
          }
          Account::updateAmount($request->get('cuenta'), $last_balance);
        }

        return redirect('/flujo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_row = AccountMovement::find($id);

        $account = Account::find($delete_row->id_account);
        $balance = ( $delete_row->type == AccountMovement::TYPE_CHARGE ) ? $delete_row->balance + $delete_row->amount : $delete_row->balance - $delete_row->amount;
        $last_balance = 0;
        $post_rows = AccountMovement::where('date', '>=', $delete_row->date)
                                    ->where('id_account', $delete_row->id_account)
                                    ->where('id', '!=', $delete_row->id)
                                    ->orderBy('date', 'asc')
                                    ->select('id','type', 'amount', 'balance')
                                    ->get();

        if ($post_rows != null)
        {
            foreach ($post_rows as $row)
            {
                \Log::debug($row);
                $last_balance = ( $row->type == AccountMovement::TYPE_CHARGE ) ? $balance - $row->amount : $balance + $row->amount;
                $data = [
                    'balance' => $last_balance,
                ];
                AccountMovement::where('id', $row->id)->update($data);
                $balance = $last_balance;
            }
            Account::updateAmount($account->id, $balance);
        }
        else {
            Account::updateAmount($account->id, $balance);
        }

        AccountMovement::where('id', $delete_row->id)->delete();

        return response(['message' => '¡Registro eliminado con exito!'], 200);
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
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $movements = AccountMovement::where('date', '>=', $fechaInicio)->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )
        {
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            $movements = AccountMovement::where('date', '<=', $fechaFin)->get();
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );

            $movements = AccountMovement::where('date', '>=', $fechaInicio)
                                        ->where('date', '<=', $fechaFin)
                                        ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            $movements = AccountMovement::all();
        }
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

        return response(['movements' => $tableColumns], 200);
    }

    public function checkConcept(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ]);

        $concept = Concept::find($request->get('id'));
        $has_courier = false;
        $type = null;
        switch ($concept->heading)
        {
            case Concept::HEADING_TO_COURIER:
                $has_courier = true;
                $type = 1;
                break;
            case Concept::HEADING_TO_URBO:
                $has_courier = true;
                $type = 2;
                break;
            case Concept::HEADING_OTHER:
                $has_courier = false;
                break;
        }

        return response(['repartidor' => $has_courier, 'tipo' => $type], 200);
    }

    public function concepts($id)
    {
        $movements = AccountMovement::where('id_account', $id)->orderBy('date', 'asc')->get();

        $tableColumns = $movements->map(function($movement) {

            $concept = Concept::find($movement->concept);
            $charge = '-';
            $payment = '-';

            if($movement->type == AccountMovement::TYPE_CHARGE)
                $charge = '$' . $movement->amount;
            if($movement->type == AccountMovement::TYPE_PAYMENT)
                $payment = '$' . $movement->amount;

            return [
                $concept->concept,
                $movement->details,
                $movement->date,
                $charge,
                $payment,
                $movement->balance,
                $movement->id,
            ];
        });

        $view_data =
        [
            'title' => 'Flujo financiero',
            'movements' => $tableColumns,
            'account' => Account::find($id),
        ];
        return view( 'flow.specific_table', $view_data );
    }

    public function dateFilterConcepts(Request $request)
    {
        $request->validate([
            'fechaInicio' => [],
            'fechaFin' => [],
            'cuenta' => ['required'],
        ]);

        $movements = null;

        if ($request->get('fechaInicio') != null && $request->get('fechaFin') == null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $movements = AccountMovement::where('date', '>=', $fechaInicio)
                                        ->where('id_account', $request->get('cuenta'))
                                        ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') != null )
        {
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );
            $movements = AccountMovement::where('date', '<=', $fechaFin)
                                        ->where('id_account', $request->get('cuenta'))
                                        ->get();
        }
        else if ($request->get('fechaInicio') != null && $request->get('fechaFin') != null )
        {
            $fechaInicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaInicio') );
            $fechaFin = \Carbon\Carbon::createFromFormat('Y-m-d', $request->get('fechaFin') );

            $movements = AccountMovement::where('date', '>=', $fechaInicio)
                                        ->where('date', '<=', $fechaFin)
                                        ->where('id_account', $request->get('cuenta'))
                                        ->get();
        }
        else if ($request->get('fechaInicio') == null && $request->get('fechaFin') == null )
        {
            $movements = AccountMovement::where('id_account', $request->get('cuenta'))->get();
        }
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

        return response(['movements' => $tableColumns], 200);
    }
}
