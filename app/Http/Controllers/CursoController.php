<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\Curso;

class CursoController extends Controller
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
      //$this->middleware('administrador', ['only' => ['create', 'store', 'index']]);
      $this->middleware('administrador');
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
         $cursos = Curso::where('estado', 1)->get();
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
         $curso = new Curso();
         $curso->codigo = $request->input('codigo');
         $curso->nombre = $request->input('nombre');
         $curso->descripcion = $request->input('descripcion');
         $curso->save();
         return response()->json(['message' => 'Se registro el Curso correctamente'], 200);
      }
   }

   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function show(Curso $curso, Request $request)
   {
      if ($request->ajax()) {
         $curso = ($curso != null && $curso->estado == 0) ? null : $curso;
         if ($curso == null) {
            $curso = new Curso();
            $curso->id = null;
            $curso->codigo = '';
            $curso->nombre = '';
            $curso->descripcion = '';
         }
         return response()->json($curso, 200);
      }
   }

   /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function edit(Curso $curso, Request $request)
   {
      if ($request->ajax()) {
         $curso = ($curso != null && $curso->estado == 0) ? null : $curso;
         if ($curso == null) {
            $curso = new Curso();
            $curso->id = null;
            $curso->codigo = '';
            $curso->nombre = '';
            $curso->descripcion = '';
         }
         return response()->json($curso, 200);
      }
   }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, Curso $curso)
   {
      if ($request->ajax()) {
         $curso->codigo = $request->input('codigo');
         $curso->nombre = $request->input('nombre');
         $curso->descripcion = $request->input('descripcion');
         $curso->save();
         return response()->json(['message' => 'Datos del Curso fueron actualizados correctamente'], 200);
      }
   }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function destroy(Curso $curso, Request $request)
   {
      if ($request->ajax()) {
         $curso->estado = 0;
         $curso->save();
         return response()->json(['message' => 'El Curso fueron eliminado exitosamente'], 200);
      }
   }
}
