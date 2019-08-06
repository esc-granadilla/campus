<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Schedule;

class ScheduleController extends Controller
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
         $horarios = Schedule::where('estado', 1)->get();
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
         try {
            $hor = Schedule::where(['desde' => $request->input('desde'), 'hasta' => $request->input('hasta')])->first();
            if ($hor != null) {
               if ($hor->estado == 0) {
                  $hor->estado = 1;
                  $hor->save();
               } else {
                  return response()->json(['type' => 'error', 'message' => 'Este horario ya esta registrado.'], 200);
               }
            } else {
               $horario = new Schedule($request->all());
               $horario->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se registro el Horario correctamente'], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(Schedule $schedule, Request $request)
   {
      if ($request->ajax()) {
         $schedule = ($schedule != null && $schedule->estado == 0) ? null : $schedule;
         return response()->json($schedule, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Schedule $schedule, Request $request)
   {
      if ($request->ajax()) {
         $schedule = ($schedule != null && $schedule->estado == 0) ? null : $schedule;
         return response()->json($schedule, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

   public function update(Request $request, Schedule $schedule)
   {
      if ($request->ajax()) {
         try {
            $hor = Schedule::where(['desde' => $request->input('desde'), 'hasta' => $request->input('hasta')])->first();
            if ($hor != null) {
               return response()->json(['type' => 'error', 'message' => 'Este horario ya esta registrado.'], 200);
            } else {
               $schedule->hasta = $request->input('hasta');
               $schedule->desde = $request->input('desde');
               $schedule->save();
            }
            return response()->json([
               'type' => 'success',
               'message' => 'Datos del Horario fueron actualizados correctamente'
            ], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function destroy(Schedule $schedule, Request $request)
   {
      if ($request->ajax()) {
         $schedule->estado = 0;
         $schedule->save();
         return response()->json(['type' => 'success', 'message' => 'El Horario fue eliminado exitosamente'], 200);
      }
   }
}
