<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Section;

class SectionController extends Controller
{

   /*
    |--------------------------------------------------------------------------
    | Seccion Controller
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
         $sections = Section::where('estado', 1)->get();
         return response()->json($sections, 200);
      }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function create(Request $request)
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
         $sec = Section::where('seccion', $request->input('seccion'))->first();
         if ($sec != null) {
            if ($sec->estado == 0) {
               $sec->estado = 1;
               $sec->save();
            } else {
               return response()->json(['type' => 'error', 'message' => 'Esta Sección ya esta registrada.'], 200);
            }
         } else {
            $section = new Section();
            $section->seccion = $request->input('seccion');
            $section->grade_id = (int)$request->input('grade_id');
            $section->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Se registro la Sección correctamente'], 200);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  Section  $section
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function show(Section  $section, Request  $request)
   {
      if ($request->ajax()) {
         $section = ($section != null && $section->estado == 0) ? null : $section;
         return response()->json($section, 200);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  Section  $section
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function edit(Section  $section, Request  $request)
   {
      if ($request->ajax()) {
         $section = ($section != null && $section->estado == 0) ? null : $section;
         return response()->json($section, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  Section  $section
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Section $section)
   {
      if ($request->ajax()) {
         $sec = Section::where('seccion', $request->input('seccion'))->first();
         if ($sec != null && ($sec->id != $section->id)) {
            return response()->json(['type' => 'error', 'message' => 'Ya existe una sección con este nombre.'], 200);
         } else {
            $section->seccion = $request->input('seccion');
            $section->grade_id = (int)$request->input('grade_id');
            $section->save();
         }
         return response()->json(['type' => 'success', 'message' => 'Datos de la sección fueron actualizados correctamente'], 200);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  Section  $section
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request  $request
    */
   public function destroy(Section $section, Request  $request)
   {
      if ($request->ajax()) {
         $section->estado = 0;
         $section->save();
         return response()->json(['type' => 'success', 'message' => 'La Sección fue eliminada exitosamente'], 200);
      }
   }
}
