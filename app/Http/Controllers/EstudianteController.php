<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Student;
use Campus\News;
use Carbon\Carbon;
use Campus\Course;

class EstudianteController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Estudiante Controller
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
   }

   public function index()
   {
      return view('panelestudiantes');
   }

   public function screenstudent(Request $request)
   {
      $request->session()->put('course', $request->input('id'));
      return view('panelestudiantes');
   }

   public function getcoursesstudent(Student $student, Request $request)
   {
      if ($request->ajax()) {
         $asignaciones = ($student->section()->first() == null) ? [] : $student->section()->first()->courses()->get();
         $cursos = [];
         foreach ($asignaciones as $asig) {
            array_push($cursos, [
               'id' => $asig->id,
               'nombre' => $asig->nombre,
               'curso' => $asig->subject()->first(),
               'seccion' => $asig->section()->first()
            ]);
         }
         return response()->json($cursos, 200);
      }
   }

   public function show(Request $request)
   {
      if ($request->session()->has('student')) {
         $student = $request->session()->get('student');
         $student = Student::where('cedula', $student[0]['cedula'])->first();
         $section = $student->section()->first();
         $student->seccion = "no asignada";
         if ($section != null)
            $student->seccion = $section->seccion;
         return view('profilestudent', compact('student'));
      }
      return view('home');
   }

   public function statusnotifications(Request $request)
   {
      if ($request->ajax()) {
         $notificaciones = News::where(['estado' => 1, 'tipo' => 'Global'])->get();
         $fecha = Carbon::now('America/Costa_Rica')->subWeek(1)->format('Y-m-d');
         $notificacionespasadas = News::whereDate('created_at', '>=', $fecha)->where(['estado' => 1, 'tipo' => 'Global'])->get();
         return response()->json(['totales' => $notificaciones->count(), 'actuales' => $notificacionespasadas->count()], 200);
      }
   }

   public function myqualifications(Request $request)
   {
      if ($request->ajax()) {
         $cedula = $request->session()->get('student')[0]->cedula;
         $student = Student::where('cedula', $cedula)->first();
         $qualifications = $student->qualifications()->where([
            'estado' => 1,
            'course_id' => (int)$request->session()->get('course')
         ])->get();
         return response()->json($qualifications, 200);
      }
   }

   private function matrizqualifications(int $id, Student $student,  Request $request)
   {
      $course = Course::where('id', (int)$request->session()->get('course'))->first();
      $examenes = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Examen', 'course_id' => $course->id])->get();
      $tareas = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Tarea', 'course_id' => $course->id])->get();
      $trabajos = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Trabajo o investigación', 'course_id' => $course->id])->get();
      $otros = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Otra', 'course_id' => $course->id])->get();
      $calificacion = ['estudiante' => $student, 'examenes' => $examenes, 'tareas' => $tareas, 'trabajos' => $trabajos, 'otros' => $otros];
      return $calificacion;
   }

   public function myqualificationsfortrimester($id, Request $request)
   {
      if ($request->ajax()) {
         $cedula = $request->session()->get('student')[0]->cedula;
         $student = Student::where('cedula', $cedula)->first();
         $qualifications = $this->matrizqualifications($id, $student, $request);
         return response()->json($qualifications, 200);
      }
   }
}
