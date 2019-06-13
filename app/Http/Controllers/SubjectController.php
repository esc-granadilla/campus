<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Subject;

class SubjectController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Asignatura Controller
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
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $cursos = Subject::where('estado', 1)->get();
         return response()->json($cursos, 200);
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
         $asig = Subject::where('codigo', strtoupper($request->input('codigo')))->first();
         if ($asig != null) {
            if ($asig->estado == 0) {
               $asig->estado = 1;
               $asig->save();
            } else {
               return response()->json(['type' => 'error', 'message' => 'Esta asignatura ya esta registrada.'], 200);
            }
         } else {
            $asignatura = new Subject();
            $asignatura->codigo = strtoupper($request->input('codigo'));
            $asignatura->nombre = $request->input('nombre');
            $asignatura->descripcion = $request->input('descripcion');
            $asignatura->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Se registro la asignatura correctamente.'], 200);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(Subject $subject, Request $request)
   {
      if ($request->ajax()) {
         $subject = ($subject != null && $subject->estado == 0) ? null : $subject;
         return response()->json($subject, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Subject $subject, Request $request)
   {
      if ($request->ajax()) {
         $subject = ($subject != null && $subject->estado == 0) ? null : $subject;
         return response()->json($subject, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  Subject  $asignatura
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Subject $subject)
   {
      if ($request->ajax()) {
         $asig = Subject::where('codigo', strtoupper($request->input('codigo')))->first();
         if ($asig != null && ($asig->id != $subject->id)) {
            return response()->json(['type' => 'error', 'message' => 'Ya existe una asignatura con este codigo.'], 200);
         } else {
            $subject->codigo = strtoupper($request->input('codigo'));
            $subject->nombre = $request->input('nombre');
            $subject->descripcion = $request->input('descripcion');
            $subject->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Datos de la asignatura fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function destroy(Subject $subject, Request $request)
   {
      if ($request->ajax()) {
         $subject->estado = 0;
         $subject->save();
         return response()->json(['type' => 'success', 'message' => 'La asignatura fue eliminada exitosamente'], 200);
      }
   }
}
