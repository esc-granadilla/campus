<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Horario;
use Carbon\Carbon;
use DateTime;

class HorarioController extends Controller
{

   /*
    |--------------------------------------------------------------------------
    | Horario Controller
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
         $horarios = Horario::where('estado', 1)->get();
         return response()->json($horarios, 200);
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
         $hor = Horario::where(['desde' => $request->input('desde'), 'hasta' => $request->input('hasta')])->first();
         if ($hor != null) {
            if ($hor->estado == 0) {
               $hor->estado = 1;
               $hor->save();
            } else {
               return response()->json(['type' => 'error', 'message' => 'Este horario ya esta registrado.'], 200);
            }
         } else {
            $horario = new Horario();
            $horario->hasta = $request->input('hasta');
            $horario->desde = $request->input('desde');
            $horario->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Se registro el Horario correctamente'], 200);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(Horario $horario, Request $request)
   {
      if ($request->ajax()) {
         $horario = ($horario != null && $horario->estado == 0) ? null : $horario;
         return response()->json($horario, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Horario $horario, Request $request)
   {
      if ($request->ajax()) {
         $horario = ($horario != null && $horario->estado == 0) ? null : $horario;
         return response()->json($horario, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function update(Request $request, Horario $horario)
   {
      if ($request->ajax()) {
         $hor = Horario::where(['desde' => $request->input('desde'), 'hasta' => $request->input('hasta')])->first();
         if ($hor != null) {
            return response()->json(['type' => 'error', 'message' => 'Este horario ya esta registrado.'], 200);
         } else {
            $horario->hasta = $request->input('hasta');
            $horario->desde = $request->input('desde');
            $horario->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Datos del Horario fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function destroy(Horario $horario, Request $request)
   {
      if ($request->ajax()) {
         $horario->estado = 0;
         $horario->save();
         return response()->json(['type' => 'success', 'message' => 'El Horario fue eliminado exitosamente'], 200);
      }
   }
}