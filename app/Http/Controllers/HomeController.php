<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Http\Middleware\Profesor;

class HomeController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('auth');
   }

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->user()->hasRole('Usuario')) {
         return view('home');
      } elseif ($request->user()->hasAnyRole(['Profesor', 'Administrador'])) {
         $profesor = $request->user()->teacher()->first();
         return view('homeprofesores', compact('profesor'));
      }
   }
}
