<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Qualification;

class QualificationController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Calificación Controller
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
      $this->middleware('profesor');
   }
   /**
    * Display a listing of the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $qualifications = Qualification::where('estado', 1)->get();
         return response()->json($qualifications, 200);
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
      if ($request->ajax()) {
         $qualifi = Qualification::where([
            'titulo' => $request->input('titulo'),
            'trimestre' => $request->input('trimestre'),
            'student_id' => $request->input('student_id')
         ])->first();
         if ($qualifi != null) {
            if ($qualifi->estado == 0) {
               $qualifi->estado = 1;
               $qualifi->save();
            } else {
               return response()->json(['type' => 'error', 'message' => 'Este nota ya esta registrada.'], 200);
            }
         } else {
            $qualification = new Qualification();
            $qualification->titulo = $request->input('titulo');
            $qualification->valor_porcentual = (float)$request->input('valor_porcentual');
            $qualification->porcentaje_obtenido = (float)$request->input('porcentaje_obtenido');
            $qualification->tipo = $request->input('tipo');
            $qualification->condicion = $request->input('condicion');
            $qualification->descripcion = $request->input('descripcion');
            $qualification->trimestre = (int)$request->input('trimestre');
            $qualification->fecha = $request->input('fecha');
            $qualification->student_id = $request->input('student_id');
            $qualification->course_id = (int)$request->session()->get('course');
            $qualification->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Se registro la nota correctamente'], 200);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  Qualification $qualification
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(Qualification $qualification, Request $request)
   {
      if ($request->ajax()) {
         $qualification = ($qualification != null && $qualification->estado == 0) ? null : $qualification;
         return response()->json($qualification, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  Qualification $qualification
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Qualification $qualification, Request $request)
   {
      if ($request->ajax()) {
         $qualification = ($qualification != null && $qualification->estado == 0) ? null : $qualification;
         return response()->json($qualification, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  Qualification $qualification
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Qualification $qualification)
   {
      if ($request->ajax()) {
         $quali = Qualification::where([
            'titulo' => $request->input('titulo'),
            'trimestre' => $request->input('trimestre'),
            'student_id' => $request->input('student_id')
         ])->first();
         if ($quali != null && $quali->id != $qualification->id) {
            return response()->json(['type' => 'error', 'message' => 'Esta nota ya esta registrada.'], 200);
         } else {
            $qualification->titulo = $request->input('titulo');
            $qualification->valor_porcentual = (float)$request->input('valor_porcentual');
            $qualification->porcentaje_obtenido = (float)$request->input('porcentaje_obtenido');
            $qualification->tipo = $request->input('tipo');
            $qualification->condicion = $request->input('condicion');
            $qualification->descripcion = $request->input('descripcion');
            $qualification->trimestre = (int)$request->input('trimestre');
            $qualification->fecha = $request->input('fecha');
            $qualification->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Datos de la nota fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  Qualification $qualification
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function destroy(Qualification $qualification, Request $request)
   {
      if ($request->ajax()) {
         $qualification->delete();
         return response()->json(['type' => 'success', 'message' => 'La Nota fue eliminada exitosamente'], 200);
      }
   }
}
