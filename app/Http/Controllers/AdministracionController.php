<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Role;

class AdministracionController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
      $this->middleware('administrador');
   }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
      return view('homeadministrador');
   }

   public function credencial($empleado_id, $role_id)
   {
      return 'completado';
   }

   public function roles(Request $request)
   {
      if ($request->ajax()) {
         $roles = Role::all();
         return response()->json($roles, 200);
      }
   }
}
