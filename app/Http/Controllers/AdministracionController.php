<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Role;
use Campus\User;
use Campus\Horario;
use Campus\Dia;
use Campus\Grado;
use Campus\Asignacioncursoprofesor;
use Campus\Estudiante;
use Campus\Teacher;
use Campus\Course;
use Campus\Section;
use Campus\Student;
use Campus\Day;
use Campus\Schedule;

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
         $profesores = Teacher::where('estado', 1)->get();
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

   public function updatecredencial(User $user, Request $request)
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

   public function asigcursohorario(Course $curso, Request $request)
   {
      if ($request->ajax()) {
         $curso->schedule()->detach();
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
         $asignaciones = Asignacioncursoprofesor::where('profesor_id', $profesor->id)->get();
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
         $horarios = $request->input('horarios');
         Asignacioncursoprofesor::where(
            [
               'profesor_id' => $profesor->id,
               'curso_id' => $curso->id,
               'grado_id' => $grado->id,
               'dia_id' => $dia->id
            ]
         )->delete();
         foreach ($horarios as $horario) {
            $asignacion = new Asignacioncursoprofesor();
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

   public function showcursosprofesors(Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $cursosids = Asignacioncursoprofesor::where('grado_id', $grado->id)->get();
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
   /*
   public function showprofesorscurso(Curso $curso, Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $cursosids = Asignacioncursoprofesor::where(['grado_id' => $grado->id, 'curso_id' => $curso->id])->get();
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
*/
   public function showprofesorscurso(Estudiante $estudiante, Curso $curso, Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $myasignacion = $estudiante->Asignacioncursoprofesors()->where('curso_id', $curso->id)->first();
         $profesores = [];
         $cargar = true;
         if ($myasignacion != null) {
            $profesor = Profesor::find($myasignacion->profesor_id);
            if ($profesor->estado == 1) {
               array_push($profesores, $profesor);
               $cargar = false;
            }
         }
         if ($cargar) {
            $cursosids = Asignacioncursoprofesor::where(['grado_id' => $grado->id, 'curso_id' => $curso->id])->get();
            $cursosids = $cursosids->groupBy('profesor_id');
            foreach ($cursosids as $cursosid) {
               $profesor = Profesor::find($cursosid[0]->profesor_id);
               if ($profesor->estado == 1)
                  array_push($profesores, $profesor);
            }
         }
         return response()->json($profesores, 200);
      }
   }
   /*
   public function showhorarioscurso(Profesor $profesor, Curso $curso, Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $cursosids = Asignacioncursoprofesor::where(
            ['grado_id' => $grado->id, 'curso_id' => $curso->id, 'profesor_id' => $profesor->id]
         )->get();
         $cursosids = $cursosids->groupBy('dia_id');
         $diasHorarios = [];
         foreach ($cursosids as $cursosid) {
            $dia = Dia::find($cursosid[0]->dia_id);
            $valido = false;
            $horarios = [];
            foreach ($cursosid as $cursosi) {
               $horario = Horario::find($cursosi->horario_id);
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
   }*/

   public function showhorarioscurso(Estudiante $estudiante, Profesor $profesor, Curso $curso, Grado $grado, Request $request)
   {
      if ($request->ajax()) {
         $myasignacion = $estudiante->Asignacioncursoprofesors()->get();
         $listnohorarios = [];
         foreach ($myasignacion as $my) {
            array_push($listnohorarios, ['asignacion' => $my->id, 'horario_id' => $my->horario_id, 'dia_id' => $my->dia_id]);
         }
         $cursosids = Asignacioncursoprofesor::where(
            ['grado_id' => $grado->id, 'curso_id' => $curso->id, 'profesor_id' => $profesor->id]
         )->get();
         $cursosids = $cursosids->groupBy('dia_id');
         $diasHorarios = [];
         foreach ($cursosids as $cursosid) {
            $dia = Dia::find($cursosid[0]->dia_id);
            $valido = false;
            $horarios = [];
            foreach ($cursosid as $cursosi) {
               $horario = Horario::find($cursosi->horario_id);
               $asigna = Asignacioncursoprofesor::where(
                  [
                     'horario_id' => $horario->id,
                     'dia_id' => $dia->id,
                     'grado_id' => $grado->id,
                     'curso_id' => $curso->id,
                     'profesor_id' => $profesor->id
                  ]
               )->first();
               $nuevo = true;
               foreach ($listnohorarios as $no) {
                  if ($no['horario_id'] === $horario->id && $no['dia_id'] === $dia->id) {
                     if ($asigna->id === $no['asignacion']) {
                        $valido = true;
                        array_push($horarios, [
                           'id' => $horario->id,
                           'desde' => $horario->desde,
                           'hasta' => $horario->hasta,
                           'selected' => true
                        ]);
                     }
                     $nuevo = false;
                     break;
                  }
               }
               if ($horario->estado == 1 && $nuevo) {
                  $valido = true;
                  array_push($horarios, [
                     'id' => $horario->id,
                     'desde' => $horario->desde,
                     'hasta' => $horario->hasta,
                     'selected' => false
                  ]);
               }
            }
            if ($valido)
               array_push($diasHorarios, ['Dia' => $dia, 'Horarios' => $horarios]);
         }
         return response()->json($diasHorarios, 200);
      }
   }

   public function asigcursohorarioestudiante(Estudiante $estudiante, Profesor $profesor, Curso $curso, Grado $grado, Dia $dia, Request $request)
   {
      if ($request->ajax()) {
         $asignaciones = Asignacioncursoprofesor::where(
            [
               'dia_id' => $dia->id,
               'grado_id' => $grado->id,
               'curso_id' => $curso->id,
               'profesor_id' => $profesor->id
            ]
         )->get();
         foreach ($asignaciones as $asig) {
            $estudiante->asignacioncursoprofesors()->detach($asig);
         }
         $horarios = $request->input('horarios');
         foreach ($horarios as $horario) {
            $asignacion = Asignacioncursoprofesor::where(
               [
                  'horario_id' => $horario['id'],
                  'dia_id' => $dia->id,
                  'grado_id' => $grado->id,
                  'curso_id' => $curso->id,
                  'profesor_id' => $profesor->id
               ]
            )->first();
            $estudiante->asignacioncursoprofesors()->attach($asignacion);
         }
         return response()->json(['message' => "Asignaciones creadas correctamente"], 200);
      }
   }

   public function studentsforsection(Request $request, Section $section)
   {
      if ($request->ajax()) {
         $students = $section->students()->where('estado', 1)->get();
         return response()->json($students, 200);
      }
   }

   /**
    * Get all values from specific key in a multidimensional array
    *
    * @param $key string
    * @param $arr array
    * @return null|string|array
    */
   public function array_value_recursive($key, array $arr)
   {
      $val = array();
      array_walk_recursive($arr, function ($v, $k) use ($key, &$val) {
         if ($k == $key) array_push($val, $v);
      });
      return $val;
   }

   public function addstudentsforsection(Request $request, Section $section)
   {
      if ($request->ajax()) {
         try {
            $students = $section->students()->where('estado', 1)->get();
            foreach ($students as $student) {
               $student->section_id = null;
               $student->save();
            }
            $students_ids = $this->array_value_recursive('id', $request->input('students'));
            $students = Student::whereIn('id', $students_ids)->get();
            foreach ($students as $student) {
               $student->section_id = $section->id;
               $student->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se asigno la sección a los estudiantes exitosamente'], 200);
         } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 200);
         }
      }
   }

   public function setstudentsforsection(Request $request, Section $section)
   {
      if ($request->ajax()) {
         try {
            $students_ids = $this->array_value_recursive('id', $request->input('students'));
            $students = Student::whereIn('id', $students_ids)->get();
            foreach ($students as $student) {
               $student->section_id = $section->id;
               $student->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se cambio la sección a los estudiantes exitosamente'], 200);
         } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 200);
         }
      }
   }

   public function lessonsforcourses(Request $request, Course $course)
   {
      if ($request->ajax()) {
         $lessons = $course->lessons()->get();
         $array = [];
         foreach ($lessons as $lesson) {
            array_push($array, [
               'id' => $lesson->id,
               'day_id' => $lesson->day_id,
               'schedule_id' => $lesson->schedule_id,
               'course_id' => $lesson->course_id,
               'dia' => $lesson->day()->first(),
               'horario' => $lesson->schedule()->first(),
               'curso' => $lesson->course()->first(),
            ]);
         }
         return response()->json($array, 200);
      }
   }

   public function lessonsstock(Request $request, Course $course)
   {
      try {
         if ($request->ajax()) {
            $teacher = $course->teacher()->first();
            $section = $course->section()->first();
            $lessons = $this->MatrizLessons();
            $lessons = $this->filter_teacher($teacher, $lessons);
            if ($lessons == null) $lessons = [];
            $lessons = $this->filter_section($section, $lessons);
            if ($lessons == null) $lessons = [];
            return response()->json($lessons, 200);
         }
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function MatrizLessons()
   {
      try {
         $days = Day::all()->toArray();
         $schedule = Schedule::where('estado', 1)->get()->toArray();
         $matriz = [];
         foreach ($days as $day) {
            array_push($matriz, ['dia' => $day, 'horario' => $schedule]);
         }
         return $matriz;
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function filter_teacher(Teacher $teacher, array $matriz)
   {
      try {
         $courses = $teacher->courses()->where('estado', 1)->get();
         $lessons = [];
         foreach ($courses as $course) {
            $lesson = $course->lessons()->get();
            if ($lesson != null && $lesson->count() > 0)
               array_push($lessons, $lesson);
         }
         foreach ($lessons as $lesson) {
            $day = $lesson->day()->first();
            $schedule = $lesson->schedule()->first();
            foreach ($matriz as $array) {
               if ($array['dia']['id'] == $day->id) {
                  $array['horario'] = array_filter($array['horario'], function ($var) use ($schedule) {
                     return $var['id'] != $schedule->id;
                  });
               }
            }
         }
         $matriz = array_filter($matriz, function ($var) {
            return ($var['horario'] != null) && (count($var['horario']) > 0);
         });
         return $matriz;
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function filter_section(Section $section, array $matriz)
   {
      try {
         $courses = $section->courses()->where('estado', 1)->get();
         $lessons = [];
         foreach ($courses as $course) {
            $lesson = $course->lessons()->get();
            if ($lesson != null && $lesson->count() > 0)
               array_push($lessons, $lesson);
         }
         foreach ($lessons as $lesson) {
            $day = $lesson->day()->first();
            $schedule = $lesson->schedule()->first();
            foreach ($matriz as $array) {
               if ($array['dia']['id'] == $day->id) {
                  $array['horario'] = array_filter($array['horario'], function ($var) use ($schedule) {
                     return $var['id'] != $schedule->id;
                  });
               }
            }
         }
         $matriz = array_filter($matriz, function ($var) {
            return ($var['horario'] != null) && (count($var['horario']) > 0);
         });
         return $matriz;
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }
}
