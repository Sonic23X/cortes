<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sheet;
use App\Models\SheetMovement;

class SheetController extends Controller
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
            'title' => 'Hojas',
            'sheets' => Sheet::all(),
        ];

        return view('sheets/main_table', $view_data);
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
            'title' => 'Hojas',
            'sheets' => Sheet::all(),
        ];

        return view('sheets/new_register', $view_data);
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
            'hoja' => ['required', 'numeric'],
            'detalle' => [],
            'fecha' => ['required'],
            'tipo' => ['required', 'numeric'],  
        ], $errorMessages);

        $fechaRequest = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', str_replace('T', ' ', $request->get('fecha')) );

        $last_row = SheetMovement::where('date', '<=', $fechaRequest)
                                ->where('id_sheet', $request->get('hoja'))
                                ->orderBy('date', 'desc')
                                ->first();

        if ($last_row != null)
            $last_row = $last_row->balance;
        else
            $last_row = 0;

        $balance = 0;
        $data = null;

        if ($request->get('tipo') == 1) 
        {
            $balance -= $request->get('cantidad');

            $data = [
                'id_sheet' => $request->get('hoja'), 
                'details' => $request->get('detalle'), 
                'date' => $fechaRequest,
                'type' => SheetMovement::TYPE_OUT,
                'amount' => $request->get('cantidad'),
                'balance' => $balance,
            ];
        }
        else
        {
            $balance += $request->get('cantidad');

            $data = [
                'id_sheet' => $request->get('hoja'), 
                'details' => $request->get('detalle'), 
                'date' => $fechaRequest,
                'type' => SheetMovement::TYPE_IN,
                'amount' => $request->get('cantidad'),
                'balance' => $balance,
            ];
        }

        $actual_movement = SheetMovement::create($data);

        // Actualizamos el resto de registros posteriores a esa fecha
        $last_balance = 0;
        $post_rows = SheetMovement::where('date', '>', $fechaRequest)
                                ->where('id_sheet', $request->get('hoja'))
                                ->orderBy('date', 'asc')
                                ->first();

        foreach ($post_rows as $row)
        {
            $last_balance = ( $row->type == SheetMovement::TYPE_OUT ) ? $balance - $row->amount : $balance + $row->amount;

            $data = [
                'balance' => $last_balance,
            ];

            SheetMovement::where('id', $row->id)->update($data);
            $balance = $last_balance;
        }

        return redirect('/hojas');
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
            'title' => 'Hojas',
            'sheets' => Sheet::all(),
            'movement' => SheetMovement::find($id),
        ];
        return view( 'sheets/update_register', $view_data );
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
            'hoja' => ['required', 'numeric'],
            'detalle' => [],
            'fecha' => ['required'],
            'tipo' => ['required', 'numeric'],  
        ], $errorMessages);

        $fechaRequest = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', str_replace('T', ' ', $request->get('fecha')) );

        $actual_movement = SheetMovement::find($id);

        if ($actual_movement->id_sheet == $request->get('hoja')) 
        {
            $last_row = SheetMovement::where('date', '<', $fechaRequest)
                                    ->where('id_sheet', $request->get('hoja'))
                                    ->orderBy('date', 'desc')
                                    ->first();

            if ($last_row != null)
                $last_row = $last_row->balance;
            else
                $last_row = 0;

            $balance = 0;
            $data = null;

            if ($request->get('tipo') == 1) 
            {
                $balance -= $request->get('cantidad');

                $data = [
                    'id_sheet' => $request->get('hoja'), 
                    'details' => $request->get('detalle'), 
                    'date' => $fechaRequest,
                    'type' => SheetMovement::TYPE_OUT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                ];
            }
            else
            {
                $balance += $request->get('cantidad');

                $data = [
                    'id_sheet' => $request->get('hoja'), 
                    'details' => $request->get('detalle'), 
                    'date' => $fechaRequest,
                    'type' => SheetMovement::TYPE_IN,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                ];
            }

            $actual_movement = SheetMovement::create($data);

            // Actualizamos el resto de registros posteriores a esa fecha
            $last_balance = 0;
            $post_rows = SheetMovement::where('date', '>', $fechaRequest)
                                    ->where('id_sheet', $request->get('hoja'))
                                    ->orderBy('date', 'asc')
                                    ->first();

            foreach ($post_rows as $row)
            {
                $last_balance = ( $row->type == SheetMovement::TYPE_OUT ) ? $balance - $row->amount : $balance + $row->amount;

                $data = [
                    'balance' => $last_balance,
                ];

                SheetMovement::where('id', $row->id)->update($data);
                $balance = $last_balance;
            }   
        }
        else
        {
            //Quitamos el movimiento de la cuenta anterior
            $last_row = SheetMovement::where('date', '<', $actual_movement->date)
                                    ->where('id_sheet', $actual_movement->id_sheet)
                                    ->orderBy('date', 'desc')
                                    ->first();

            $new_balance = ( $last_row != NULL ) ? $last_row->amount : 0;

            $post_rows = SheetMovement::where('date', '>', $movement->date)
                                        ->where('id_account', $actual_movement->id_sheet)
                                        ->orderBy('date', 'asc')
                                        ->get();

            foreach ($post_rows as $row) {
                $last_balance = ( $row->type == SheetMovement::TYPE_OUT ) ? $new_balance - $row->amount : $new_balance + $row->amount;
                $data = [
                    'balance' => $last_balance,
                ];
                SheetMovement::where('id', $row->id)->update($data);
                $new_balance = $last_balance;
            }

            //Continua el flujo normal
            $last_row = SheetMovement::where('date', '<', $fechaRequest)
                                    ->where('id_sheet', $request->get('hoja'))
                                    ->orderBy('date', 'desc')
                                    ->first();

            if ($last_row != null)
                $last_row = $last_row->balance;
            else
                $last_row = 0;

            $balance = 0;
            $data = null;

            if ($request->get('tipo') == 1) 
            {
                $balance -= $request->get('cantidad');

                $data = [
                    'id_sheet' => $request->get('hoja'), 
                    'details' => $request->get('detalle'), 
                    'date' => $fechaRequest,
                    'type' => SheetMovement::TYPE_OUT,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                ];
            }
            else
            {
                $balance += $request->get('cantidad');

                $data = [
                    'id_sheet' => $request->get('hoja'), 
                    'details' => $request->get('detalle'), 
                    'date' => $fechaRequest,
                    'type' => SheetMovement::TYPE_IN,
                    'amount' => $request->get('cantidad'),
                    'balance' => $balance,
                ];
            }

            $actual_movement = SheetMovement::create($data);

            $last_balance = 0;
            $post_rows = SheetMovement::where('date', '>', $fechaRequest)
                                    ->where('id_sheet', $request->get('hoja'))
                                    ->orderBy('date', 'asc')
                                    ->first();

            foreach ($post_rows as $row)
            {
                $last_balance = ( $row->type == SheetMovement::TYPE_OUT ) ? $balance - $row->amount : $balance + $row->amount;

                $data = [
                    'balance' => $last_balance,
                ];

                SheetMovement::where('id', $row->id)->update($data);
                $balance = $last_balance;
            } 
        }

        return redirect('/hojas');
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
