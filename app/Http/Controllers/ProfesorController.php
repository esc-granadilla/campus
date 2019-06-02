<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Course;
use Campus\Teacher;
use Campus\Student;
use PhpParser\JsonDecoder;
use Illuminate\Support\Facades\Session;

class ProfesorController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Profesor Controller
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
      $this->middleware('profesor');
   }

   public function index()
   {
      return view('panelprofesores');
   }

   public function screenteacher(Request $request)
   {
      $request->session()->put('course', $request->input('id'));
      return view('panelprofesores');
   }


   public function getcoursesteacher(Teacher $teacher, Request $request)
   {
      if ($request->ajax()) {
         $asignaciones = $teacher->courses()->get();
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

   public function studentsforcourse(Request $request)
   {
      if ($request->ajax()) {
         $course_id = $request->session()->get('course');
         $course = Course::where('id', (int)$course_id)->first();
         $students = $course->section()->first()->students()->where('estado', 1)->get();
         return response()->json($students, 200);
      }
   }

   public function qualificationsforstudent(Student $student, Request $request)
   {
      if ($request->ajax()) {
         $qualifications = $student->qualifications()->where([
            'estado' => 1,
            'course_id' => (int)$request->session()->get('course')
         ])->get();
         return response()->json($qualifications, 200);
      }
   }

   private function matrizqualifications(int $id, Request $request)
   {
      $course = Course::where('id', (int)$request->session()->get('course'))->first();
      $section = $course->section()->first();
      $students = $section->students()->where('estado', 1)->get();
      $calificaciones = [];
      foreach ($students as $student) {
         $examenes = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Examen'])->get();
         $tareas = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Tarea'])->get();
         $trabajos = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Trabajo o investigación'])->get();
         $otros = $student->qualifications()->where(['trimestre' => $id, 'tipo' => 'Otra'])->get();
         $calificacion = ['estudiante' => $student, 'examenes' => $examenes, 'tareas' => $tareas, 'trabajos' => $trabajos, 'otros' => $otros];
         array_push($calificaciones, $calificacion);
      }
      return $calificaciones;
   }

   public function qualificationsfortrimester($id, Request $request)
   {
      if ($request->ajax()) {
         $qualifications = $this->matrizqualifications($id, $request);
         return response()->json($qualifications, 200);
      }
   }

   public function qualificationsexport($id, Request $request)
   {
      $calificaciones = $this->matrizqualifications($id, $request);
   }

   public function studentsexport($id, Student $student, Request $request)
   {
      $qualifications = $this->matrizqualifications($id, $request);
      $calificacion = [];
      foreach ($qualifications as $qualification) {
         if ($qualification['estudiante']->id == $student->id) {
            $calificacion = $qualification;
            break;
         }
      }
   }
}
