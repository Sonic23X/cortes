<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Account;
use App\Models\User;

class UserController extends Controller
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
            'title' => 'Usuarios',
            'couriers' => User::typeCourier( )->get( ),
        ];

        return view( 'users/users_table', $view_data );
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
            'title' => 'Usuarios',
        ];

        return view( 'users/new_user', $view_data );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => ['required'],
            'status' => ['required', 'numeric'],
            'apellidos' => ['required'],
            'email' => ['required'],
            'terminal' => [],
        ]);

        $data = 
        [
            'name' => $request->get('nombre'),
            'last_name' => $request->get('apellidos'),
            'email' => $request->get('email'),
            'password' => Hash::make('123456789'),
            'status' => ($request->get('status') == 1) ? User::ACTIVE : User::NOT_ACTIVE,
            'terminal' => ($request->get('termianl') != '') ? $request->get('termianl') : null ,
            'type' => User::TYPE_COURIER,
        ];

        User::create($data);

        return redirect('/usuarios');
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
