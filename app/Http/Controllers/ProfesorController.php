<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Campus\Http\Controllers\Controller;
use Campus\User;
use Campus\Role;
use Campus\Profesor;

class ProfesorController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

   use RegistersUsers;
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
      //
   }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
   {
      return view('registerprofesor');
   }


   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
   {
      $role = Role::where('nombre', 'Profesor')->first();
      $user = User::create([
         'name' => $request->input('name'),
         'email' => $request->input('email'),
         'password' => bcrypt($request->input('password')),
      ]);

      $user->roles()->attach($role);

      $profesor = new Profesor();
      $profesor->cedula = $request->input('cedula');
      $profesor->nombre = $request->input('nombre');
      $profesor->primer_apellido = $request->input('primer_apellido');
      $profesor->segundo_apellido = $request->input('segundo_apellido');
      $profesor->fecha_nacimiento = $request->input('fecha_nacimiento');
      $profesor->puesto = $request->input('puesto');
      $profesor->fecha_ingreso = $request->input('fecha_ingreso');
      $profesor->telefono1 = $request->input('telefono1');
      $profesor->telefono2 = $request->input('telefono2');
      $profesor->estado = 1;

      $user->profesor()->save($profesor);
      return view('homeprofesores');
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
