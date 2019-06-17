<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Role;
use Campus\User;
use Campus\Teacher;
use Campus\Course;
use Campus\Section;
use Campus\Student;
use Campus\Day;
use Campus\Schedule;
use Campus\Lesson;

class AdministracionController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Administrador Controller
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
            $lessons = $this->filter_section($section, $lessons);
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
         return $this->filter($courses, $matriz);
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function filter_section(Section $section, array $matriz)
   {
      try {
         $courses = $section->courses()->where('estado', 1)->get();
         return $this->filter($courses, $matriz);
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function filter($courses, array $matriz)
   {
      try {
         $lessons = [];
         foreach ($courses as $course) {
            $lecciones = $course->lessons()->get();
            if ($lecciones->count() > 0)
               array_push($lessons, ...$lecciones);
         }
         foreach ($lessons as $lesson) {
            $day = $lesson->day()->first();
            $schedule = $lesson->schedule()->first();
            for ($i = count($matriz) - 1; $i >= 0; $i--) {
               if ($matriz[$i]['dia']['id'] == $day->id) {
                  $matriz[$i]['horario'] = array_filter($matriz[$i]['horario'], function ($var) use ($schedule) {
                     return $var['id'] != $schedule->id;
                  });
               }
            }
         }
         $array = [];
         for ($i = count($matriz) - 1; $i >= 0; $i--) {
            if (($matriz[$i]['horario'] != null) || (count($matriz[$i]['horario']) > 0)) {
               array_push($array, $matriz[$i]);
            }
         }
         return $array;
      } catch (\Exception $e) {
         $output = new \Symfony\Component\Console\Output\ConsoleOutput();
         $output->writeln($e->getMessage());
      }
   }

   public function addlessonsforcourse(Request $request, Course $course)
   {
      if ($request->ajax()) {
         try {
            Lesson::where('course_id', $course->id)->delete();
            $lessons = $request->input('lessons');
            foreach ($lessons as $leccion) {
               $leccion['course_id'] = $course->id;
               $lesson = new Lesson($leccion);
               $lesson->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se asigno las lecciones al curso exitosamente'], 200);
         } catch (\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 200);
         }
      }
   }
}
