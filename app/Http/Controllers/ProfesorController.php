<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Course;
use Campus\Teacher;
use Campus\Student;

class ProfesorController extends Controller
{
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
}
