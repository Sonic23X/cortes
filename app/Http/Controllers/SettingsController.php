<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concept;
use App\Models\Account;
use App\Models\Place;
use App\Models\Sheet;

class SettingsController extends Controller
{
    public function index()
    {
        $view_data = 
        [
            'title' => 'Configuración',
            'concepts' => Concept::all(),
            'accounts' => Account::all(),
            'places' => Place::all(),
            'sheets' => Sheet::all(),
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
            'display' => ($request->get('acceso') == '1') ? Account::DISPLAY_ALL_USERS : Account::DISPLAY_ROOT_USERS,
        ];

        Account::create($data);

        return response(['message' => 'Cuenta creada', 'cuentas' => Account::all()], 200);
    }

    public function SavePlace(Request $request)
    {
        $data =
        [
            'name' => $request->get('nombre'),
        ];

        Place::create($data);

        return response(['message' => 'Negocio creado', 'negocios' => Place::all()], 200);
    }

    public function SaveSheet(Request $request)
    {
        $data =
        [
            'name' => $request->get('nombre'),
        ];

        Sheet::create($data);

        return response(['message' => 'Hoja creada', 'hojas' => Sheet::all()], 200);
    }
}
