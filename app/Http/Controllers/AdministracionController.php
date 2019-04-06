<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Role;
use Campus\Profesor;
use Campus\User;
use Campus\Curso;
use Campus\Horario;
use Campus\Dia;
use Campus\Grado;
use Campus\AsignacionCursoProfesor;

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
         $profesores = Profesor::where('estado', 1)->get();
         for ($i = 0; $i < sizeof($profesores); $i++) {
            $profesor = $profesores[$i]->user->hasRole('Profesor');
            $administrador = $profesores[$i]->user->hasRole('Administrador');
            $rolestouser[$i] = [
               'id' => $profesores[$i]->id, 'nombre' => $profesores[$i]->nombre . ' ' .
                  $profesores[$i]->primer_apellido, 'cedula' => $profesores[$i]->cedula,
               'puesto' => $profesores[$i]->puesto, 'telefono' => $profesores[$i]->telefono1,
               'profesor' => $profesor, 'administrador' => $administrador, 'estado' => $profesores[$i]->estado,
               'user_id' => $profesores[$i]->user_id
            ];
         }
         return response()->json($rolestouser, 200);
      }
   }

   public function credencial(User $user, Request $request)
   {
      if ($request->ajax()) {
         $accion = (boolean)$request->input('attach');
         $role = Role::where('nombre', $request->input('rol'))->first();
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

   public function asigcursohorario(Curso $curso, Request $request)
   {
      if ($request->ajax()) {
         $curso->horarios()->detach();
         $horarios = $request->input('horarios');
         foreach ($horarios as $horario) {
            $h = Horario::where('id', $horario["id"])->first();
            $curso->horarios()->attach($h);
         }
         return response()->json(['message' => "Horarios ingresados correctamente"], 200);
      }
   }

   public function cursohorario(Curso $curso, Request $request)
   {
      if ($request->ajax()) {
         $horarios = $curso->horarios->toArray();
         return response()->json($horarios, 200);
      }
   }

   public function showcursohorarioprofesor(Profesor $profesor, Curso $curso, Grado $grado, Dia $dia, Request $request)
   {
      if ($request->ajax()) {
         $asignaciones = AsignacionCursoProfesor::where('profesor_id', $profesor->id)->get();
         $horarios = $curso->horarios()->get();
         $horariospermitidos = [];
         foreach ($horarios as $horario) {
            if ($asignaciones != null || count($asignaciones) > 0) {
               $agregar = true;
               foreach ($asignaciones as $asignacion) {
                  if ($asignacion->id_horario == $horario->id) {
                     if (
                        $asignacion->id_grado == $grado->id ||
                        $asignacion->id_dia == $dia->id ||
                        $asignacion->id_curso == $curso->id
                     ) {
                        array_push(
                           $horariospermitidos,
                           [
                              'id' => $horario->id,
                              'desde' => $horario->desde,
                              'hasta' => $horario->hasta,
                              'selected' => true
                           ]
                        );
                     }
                     $agregar = false;
                     break;
                  }
               }
               if ($agregar) {
                  array_push(
                     $horariospermitidos,
                     ['id' => $horario->id, 'desde' => $horario->desde, 'hasta' => $horario->hasta, 'selected' => false]
                  );
               }
            }
         }
         return response()->json($horariospermitidos, 200);
      }
   }
}
