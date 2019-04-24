<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Campus\Http\Controllers\Controller;
use Campus\User;
use Campus\Role;
use Campus\Profesor;
use Campus\Asignacioncursoprofesor;
use Campus\Curso;
use Campus\Grado;
use Campus\Dia;
use Campus\Horario;

class ProfesorController extends Controller
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

   use RegistersUsers;
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $profesores = Profesor::where('estado', 1)->get();
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
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show($id, Request $request)
   {
      if ($request->ajax()) {
         $profesor = Profesor::where('cedula', $id)->first();
         $profesor = ($profesor != null && $profesor->estado == 0) ? null : $profesor;
         if ($profesor == null) {
            $profesor = new Profesor();
            $profesor->id = null;
            $profesor->cedula = '';
            $profesor->nombre = '';
            $profesor->primer_apellido = '';
            $profesor->segundo_apellido = '';
            $profesor->fecha_nacimiento = null;
            $profesor->puesto = '';
            $profesor->fecha_ingreso = null;
            $profesor->telefono1 = '';
            $profesor->telefono2 = '';
         }
         return response()->json($profesor, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit($id, Request $request)
   {
      if ($request->ajax()) {
         $profesor = Profesor::where('cedula', $id)->first();
         $profesor = ($profesor != null && $profesor->estado == 0) ? null : $profesor;
         if ($profesor == null) {
            $profesor = new Profesor();
            $profesor->id = null;
            $profesor->cedula = '';
            $profesor->nombre = '';
            $profesor->primer_apellido = '';
            $profesor->segundo_apellido = '';
            $profesor->fecha_nacimiento = null;
            $profesor->puesto = '';
            $profesor->fecha_ingreso = null;
            $profesor->telefono1 = '';
            $profesor->telefono2 = '';
         }
         return response()->json($profesor, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Profesor $profesor)
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
         $profesor->nombre = $request->input('nombre');
         $profesor->primer_apellido = $request->input('primer_apellido');
         $profesor->segundo_apellido = $request->input('segundo_apellido');
         $profesor->fecha_nacimiento = $request->input('fecha_nacimiento');
         $profesor->puesto = $request->input('puesto');
         $profesor->fecha_ingreso = $request->input('fecha_ingreso');
         $profesor->telefono1 = $request->input('telefono1');
         $profesor->telefono2 = $request->input('telefono2');
         $profesor->save();
         return response()->json(['message' => 'Datos del Profesor fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, Profesor $profesor)
   {
      if ($request->ajax()) {
         $profesor->estado = 0;
         $profesor->save();
         return response()->json(['message' => 'El Profesor fue eliminado correctamente'], 200);
      }
   }

   public function getCursosProfesor(Profesor $profesor, Request $request)
   {
      if ($request->ajax()) {
         $asignaciones = Asignacioncursoprofesor::where('profesor_id', $profesor->id)->get();
         $cursos = [];
         foreach ($asignaciones as $asig) {
            $curso = Curso::where('id', $asig->curso_id)->first();
            $grado = Grado::where('id', $asig->grado_id)->first();
            $dia = Dia::where('id', $asig->dia_id)->first();
            $horario = Horario::where('id', $asig->horario_id)->first();
            array_push($cursos, ['id' => $asig->id, 'curso' => $curso, 'grado' => $grado, 'dia' => $dia, 'horario' => $horario]);
         }
         return response()->json($cursos, 200);
      }
   }
}
