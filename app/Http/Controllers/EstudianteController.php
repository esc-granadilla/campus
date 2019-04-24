<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Estudiante;

class EstudianteController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Estudiantes Controller
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
      $this->middleware('administrador', ['only' => ['create', 'store', 'update', 'destroy']]);
      $this->middleware('profesor', ['only' => ['index', 'show', 'edit']]);
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $estudiantes = Estudiante::where('estado', 1)->get();
         return response()->json($estudiantes, 200);
      }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //
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
         $estudiante = Estudiante::where('cedula', $id)->first();
         $estudiante = ($estudiante != null && $estudiante->estado == 0) ? null : $estudiante;
         if ($estudiante == null) {
            $estudiante = new Estudiante();
            $estudiante->id = null;
            $estudiante->cedula = '';
            $estudiante->nombre = '';
            $estudiante->primer_apellido = '';
            $estudiante->segundo_apellido = '';
            $estudiante->fecha_nacimiento = null;
            $estudiante->grado = '';
            $estudiante->adecuacion = '';
         }
         return response()->json($estudiante, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Estudiante $estudiante, Request $request)
   {
      if ($request->ajax()) {
         $estudiante = ($estudiante != null && $estudiante->estado == 0) ? null : $estudiante;
         if ($estudiante == null) {
            $estudiante = new Estudiante();
            $estudiante->id = null;
            $estudiante->cedula = '';
            $estudiante->nombre = '';
            $estudiante->primer_apellido = '';
            $estudiante->segundo_apellido = '';
            $estudiante->fecha_nacimiento = null;
            $estudiante->grado = '';
            $estudiante->adecuacion = '';
         }
         return response()->json($estudiante, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Estudiante $estudiante)
   {
      $this->validate($request, [
         'nombre' => 'required|string|min:3|max:50',
         'primer_apellido' => 'required|string|min:3|max:80',
         'segundo_apellido' => 'required|string|min:3|max:80',
         'fecha_nacimiento' => ' required',
      ]);
      if ($request->ajax()) {
         $estudiante->nombre = $request->input('nombre');
         $estudiante->primer_apellido = $request->input('primer_apellido');
         $estudiante->segundo_apellido = $request->input('segundo_apellido');
         $estudiante->fecha_nacimiento = $request->input('fecha_nacimiento');
         $estudiante->grado = $request->input('grado');
         $estudiante->adecuacion = $request->input('adecuacion');
         $estudiante->save();
         return response()->json(['message' => 'Datos del Estudiante fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, Estudiante $estudiante)
   {
      if ($request->ajax()) {
         $estudiante->estado = 0;
         $estudiante->save();
         return response()->json(['message' => 'El Estudiante fue eliminado correctamente'], 200);
      }
   }
}
