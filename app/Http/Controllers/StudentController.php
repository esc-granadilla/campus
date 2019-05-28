<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Student;
use Campus\Section;

class StudentController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Estudiantes Controller
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
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $estudiantes = Student::where('estado', 1)->get();
         return response()->json($estudiantes, 200);
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
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show($id, Request $request)
   {
      if ($request->ajax()) {
         $estudiante = Student::where('cedula', $id)->first();
         $estudiante = ($estudiante != null && $estudiante->estado == 0) ? new Student() : $estudiante;
         return response()->json($estudiante, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Student $student, Request $request)
   {
      if ($request->ajax()) {
         $student = ($student != null && $student->estado == 0) ? new Student() : $student;
         return response()->json($student, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Student $student)
   {
      $this->validate($request, [
         'nombre' => 'required|string|min:3|max:50',
         'primer_apellido' => 'required|string|min:3|max:80',
         'segundo_apellido' => 'required|string|min:3|max:80',
         'fecha_nacimiento' => ' required',
      ]);
      try {
         if ($request->ajax()) {
            $student->nombre = $request->input('nombre');
            $student->primer_apellido = $request->input('primer_apellido');
            $student->segundo_apellido = $request->input('segundo_apellido');
            $student->fecha_nacimiento = $request->input('fecha_nacimiento');
            $student->adecuacion = $request->input('adecuacion');
            if ($request->input('section_id') != null) {
               $student->section_id = (int)$request->input('section_id');
            }
            $student->save();
            return response()->json(['type' => 'success', 'message' => 'Datos del Estudiante fueron actualizados correctamente'], 200);
         }
      } catch (\Exception $e) {
         return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, Student $student)
   {
      if ($request->ajax()) {
         $student->estado = 0;
         $student->save();
         return response()->json(['type' => 'success', 'message' => 'El Estudiante fue eliminado correctamente'], 200);
      }
   }
}
