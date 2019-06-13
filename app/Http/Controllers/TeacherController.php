<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Teacher;
use Campus\Role;
use Campus\User;

class TeacherController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Profesor Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
   public function __construct()
   {
      $this->middleware('auth');
      //$this->middleware('administrador', ['only' => ['create', 'store', 'index']]);
      $this->middleware('administrador');
   }


   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $profesores = Teacher::where('estado', 1)->get();
         return response()->json($profesores, 200);
      }
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
      $this->validate($request, [
         'name' => 'required|string|max:32',
         'email' => 'required|string|email|max:255|unique:users',
         'password' => 'required|string|min:6|confirmed',
         'cedula' => 'required|string|min:9|max:9',
         'nombre' => 'required|string|min:3|max:50',
         'primer_apellido' => 'required|string|min:3|max:80',
         'segundo_apellido' => 'required|string|min:3|max:80',
         'fecha_nacimiento' => ' required',
         'fecha_ingreso' => ' required',
         'telefono1' => ' required|string|min:8|max:8',
         'puesto' => 'required|string|min:3|max:50',
      ]);

      $role = Role::where('nombre', 'Profesor')->first();
      $user = User::create([
         'name' => $request->input('name'),
         'email' => $request->input('email'),
         'password' => bcrypt($request->input('password')),
      ]);

      $user->roles()->attach($role);

      $profesor = new Teacher();
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

      $user->teacher()->save($profesor);
      return redirect('/admin');
   }


   /**
    * Display the specified resource.
    *
    * @param  Teacher  $teacher
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(Teacher $teacher, Request $request)
   {
      if ($request->ajax()) {
         $teacher = ($teacher != null && $teacher->estado == 0) ? new Teacher() : $teacher;
         return response()->json($teacher, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  Teacher  $teacher
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Teacher $teacher, Request $request)
   {
      if ($request->ajax()) {
         $teacher = ($teacher != null && $teacher->estado == 0) ? new Teacher() : $teacher;
         return response()->json($teacher, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Teacher $teacher)
   {
      $this->validate($request, [
         'nombre' => 'required|string|min:3|max:50',
         'primer_apellido' => 'required|string|min:3|max:80',
         'segundo_apellido' => 'required|string|min:3|max:80',
         'fecha_nacimiento' => ' required',
         'fecha_ingreso' => ' required',
         'telefono1' => ' required|string|min:8|max:8',
         'puesto' => 'required|string|min:3|max:50',
      ]);
      if ($request->ajax()) {
         $teacher->nombre = $request->input('nombre');
         $teacher->primer_apellido = $request->input('primer_apellido');
         $teacher->segundo_apellido = $request->input('segundo_apellido');
         $teacher->fecha_nacimiento = $request->input('fecha_nacimiento');
         $teacher->puesto = $request->input('puesto');
         $teacher->fecha_ingreso = $request->input('fecha_ingreso');
         $teacher->telefono1 = $request->input('telefono1');
         $teacher->telefono2 = $request->input('telefono2');
         if ($request->has('foto')) {
            $teacher->foto = $request->input('foto');
         }
         $teacher->save();
         return response()->json(['type' => 'success', 'message' => 'Datos del Profesor fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, Teacher $teacher)
   {
      if ($request->ajax()) {
         $teacher->estado = 0;
         $teacher->save();
         return response()->json(['type' => 'success', 'message' => 'El Profesor fue eliminado correctamente'], 200);
      }
   }
}
