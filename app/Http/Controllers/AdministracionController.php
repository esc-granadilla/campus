<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Role;
use Campus\Profesor;
use Campus\User;

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

   public function roltouser(Request $request)
   {
      if ($request->ajax()) {
         $rolestouser = [];
         $i = 0;
         $profesores = Profesor::all();
         foreach ($profesores as $value) {
            $user = User::where('id', $value->user_id)->first();
            $profesor = $administrador = false;
            if ($user->hasRole('Profesor')) {
               $profesor = true;
            }
            if ($user->hasRole('Administrador')) {
               $administrador = true;
            }
            $rolestouser[$i] = [
               'id' => $value->id, 'nombre' => $value->nombre . ' ' . $value->primer_apellido,
               'cedula' => $value->cedula, 'puesto' => $value->puesto, 'telefono' => $value->telefono1,
               'profesor' => $profesor, 'administrador' => $administrador, 'estado' => $value->estado
            ];
            $i++;
         }
         return response()->json($rolestouser, 200);
      }
   }
}
