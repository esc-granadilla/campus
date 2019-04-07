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
            $agregar = true;
            if ($asignaciones != null && count($asignaciones) > 0) {
               foreach ($asignaciones as $asignacion) {
                  if ($asignacion->horario_id == $horario->id && $asignacion->dia_id == $dia->id) {
                     if (
                        $asignacion->grado_id == $grado->id &&
                        $asignacion->curso_id == $curso->id
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
            }
            if ($agregar) {
               array_push(
                  $horariospermitidos,
                  ['id' => $horario->id, 'desde' => $horario->desde, 'hasta' => $horario->hasta, 'selected' => false]
               );
            }
         }
         return response()->json($horariospermitidos, 200);
      }
   }

   public function asigcursohorarioprofesor(Profesor $profesor, Curso $curso, Grado $grado, Dia $dia, Request $request)
   {
      if ($request->ajax()) {
         if ($request->ajax()) {
            $horarios = $request->input('horarios');
            AsignacionCursoProfesor::where(
               [
                  'profesor_id' => $profesor->id,
                  'curso_id' => $curso->id,
                  'grado_id' => $grado->id,
                  'dia_id' => $dia->id
               ]
            )->delete();
            foreach ($horarios as $horario) {
               $asignacion = new AsignacionCursoProfesor();
               $asignacion->profesor_id = $profesor->id;
               $asignacion->curso_id = $curso->id;
               $asignacion->grado_id = $grado->id;
               $asignacion->dia_id = $dia->id;
               $asignacion->horario_id = $horario['id'];
               $asignacion->save();
            }
            return response()->json(['message' => "Asignaciones creadas correctamente"], 200);
         }
      }
   }

   public function showcursosprofesors(Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $cursosids = AsignacionCursoProfesor::where('grado_id', $grado->id)->get();
         $cursosids = $cursosids->groupBy('curso_id');
         $cursos = [];
         foreach ($cursosids as $cursosid) {
            $curso = Curso::find($cursosid[0]->curso_id);
            if ($curso->estado == 1)
               array_push($cursos, $curso);
         }
         return response()->json($cursos, 200);
      }
   }

   public function showprofesorscurso(Curso $curso, Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $cursosids = AsignacionCursoProfesor::where(['grado_id' => $grado->id, 'curso_id' => $curso->id])->get();
         $cursosids = $cursosids->groupBy('profesor_id');
         $profesores = [];
         foreach ($cursosids as $cursosid) {
            $profesor = Profesor::find($cursosid[0]->profesor_id);
            if ($profesor->estado == 1)
               array_push($profesores, $profesor);
         }
         return response()->json($profesores, 200);
      }
   }

   public function showhorarioscurso(Profesor $profesor, Curso $curso, Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $cursosids = AsignacionCursoProfesor::where(
            ['grado_id' => $grado->id, 'curso_id' => $curso->id, 'profesor_id' => $profesor->id]
         )->get();
         $cursosids = $cursosids->groupBy('dia_id');
         $diasHorarios = [];
         foreach ($cursosids as $cursosid) {
            $dia = Dia::find($cursosid[0]->dia_id);
            $valido = false;
            $horarios = [];
            foreach ($cursosid as $cursosi) {
               $horario = Horario::find($cursosi->id_horario);
               if ($horario->estado == 1) {
                  $valido = true;
                  array_push($horarios, $horario);
               }
            }
            if ($valido)
               array_push($diasHorarios, ['Dia' => $dia, 'Horarios' => $horarios]);
         }
         return response()->json($diasHorarios, 200);
      }
   }
}
