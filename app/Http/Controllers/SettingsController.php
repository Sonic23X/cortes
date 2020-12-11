<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concept;

class SettingsController extends Controller
{
    public function index()
    {
        $view_data = 
        [
            'title' => 'Configuración',
            'concepts' => Concept::all(),
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
}
