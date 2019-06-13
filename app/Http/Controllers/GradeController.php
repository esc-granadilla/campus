<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Grade;

class GradeController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Grado Controller
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
      $this->middleware('profesor', ['only' => ['index', 'show']]);
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $grades = Grade::where('estado', 1)->get();
         return response()->json($grades, 200);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  Grade  $grade
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function show(Grade  $grade, Request  $request)
   {
      if ($request->ajax()) {
         $grade = ($grade != null && $grade->estado == 0) ? null : $grade;
         return response()->json($grade, 200);
      }
   }
}
