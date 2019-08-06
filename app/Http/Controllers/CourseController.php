<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Course;

class CourseController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Curso Controller
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
      $this->middleware('administrador', ['only' => ['create', 'store', 'update', 'destroy']]);
      $this->middleware('profesor', ['only' => ['index', 'show', 'edit']]);
   }

   /**
    * Display a listing of the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $courses = Course::where('estado', 1)->get();
         $cursos = [];
         foreach ($courses as $asig) {
            array_push($cursos, [
               'id' => $asig->id,
               'nombre' => $asig->nombre,
               'subject_id' => $asig->subject_id,
               'teacher_id' => $asig->teacher_id,
               'section_id' => $asig->section_id,
               'asignatura' => $asig->subject()->first(),
               'profesor' => $asig->teacher()->first(),
               'seccion' => $asig->section()->first()
            ]);
         }
         return response()->json($cursos, 200);
      }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      if ($request->ajax()) {
         try {
            $cur = Course::where('nombre', $request->input('nombre'))->first();
            if ($cur != null) {
               if ($cur->estado == 0) {
                  $cur->estado = 1;
                  $cur->save();
               } else {
                  return response()->json(['type' => 'error', 'message' => 'Este curso ya esta registrado.'], 200);
               }
            } else {
               $curso = new Course($request->all());
               $curso->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se registro el Curso correctamente'], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  Course  $section
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function show(Course  $course, Request  $request)
   {
      if ($request->ajax()) {
         $course = ($course != null && $course->estado == 0) ? null : $course;
         return response()->json($course, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  Course  $section
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function edit(Course  $course, Request  $request)
   {
      if ($request->ajax()) {
         $course = ($course != null && $course->estado == 0) ? null : $course;
         return response()->json($course, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
      //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  Course  $section
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function destroy(Course $course, Request  $request)
   {
      if ($request->ajax()) {
         $course->estado = 0;
         $course->save();
         return response()->json(['type' => 'success', 'message' => 'El curso fue eliminada exitosamente'], 200);
      }
   }
}
