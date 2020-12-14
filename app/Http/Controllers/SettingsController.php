<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concept;
use App\Models\Account;

class SettingsController extends Controller
{
    public function index()
    {
        $view_data = 
        [
            'title' => 'Configuración',
            'concepts' => Concept::all(),
            'accounts' => Account::all(),
        ];

        return view('settings/main', $view_data);
    }

    public function SaveConcept(Request $request)
    {
        $data =
        [
            'concept' => $request->get('concepto'),
            'heading' => $request->get('rubro'),
        ];

        Concept::create($data);

        return response(['message' => 'Concepto creado', 'conceptos' => Concept::all()], 200);
    }

    public function UpdateConcept(Request $request)
    {
        $data =
        [
            'concept' => $request->get('concepto'),
            'heading' => $request->get('rubro'),
        ];

        Concept::where('id', $request->get('id'))->update($data);

        return response(['message' => 'Concepto creado', 'conceptos' => Concept::all()], 200);
    }

    public function SaveAccount(Request $request)
    {
        $data =
        [
            'name' => $request->get('nombre'),
            'amount' => 0,
        ];

        Account::create($data);

        return response(['message' => 'Cuenta creada', 'cuentas' => Account::all()], 200);
    }
}
