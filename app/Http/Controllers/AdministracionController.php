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
               'profesor' => $profesor, 'administrador' => $administrador, 'estado' => $value->estado, 'user_id' => $value->user_id
            ];
            $i++;
         }
         return response()->json($rolestouser, 200);
      }
   }

   public function credencial(Request $request)
   {
      if ($request->ajax()) {
         $rol_nombre = $request->input('rol');
         $user_id = $request->input('user_id');
         $accion = (boolean)$request->input('attach');
         $user = User::where('id', $user_id)->first();
         $role = Role::where('nombre', $rol_nombre)->first();
         if ($accion) {
            $user->roles()->attach($role);
            return response()->json(['message' => 'Se agrego el rol con exito'], 200);
         } else {
            $user->roles()->detach($role);
            return response()->json(['message' => 'Se quito el rol con exito'], 200);
         }
      }
      return response()->json(['message' => 'error'], 400);
   }
}
