<?php

namespace Campus\Http\Controllers;

use Illuminate\Http\Request;
use Campus\News;
use Campus\File;
use Carbon\Carbon;

class NewsController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Noticia Controller
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
      $this->middleware('profesor', ['except' => ['show', 'index']]);
   }
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         try {
            $news = News::where(['estado' => 1, 'tipo' => 'Global'])->orderBy('created_at', 'des')->get();
            foreach ($news as $item) {
               $item->files = File::where('news_id', $item->id)->orderBy('created_at', 'des')->get();
            }
            return response()->json($news, 200);
         } catch (\Throwable $th) {
            return response()->json([], 200);
         }
      } else {
         return;
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
            $newsarray = $request->all();
            $files = $request->input('files');
            $course_id = null;
            if ($request->input('tipo') == 'Grupal') {
               $course_id = (int) $request->session()->get('course');
            }
            $newsarray['course_id'] = $course_id;
            $newsarray['fecha'] = Carbon::now('America/Costa_Rica')->formatLocalized('%A %d %B %Y %H:%M:%S');
            $news = new News($newsarray);
            $news->save();
            foreach ($files as $fil) {
               $fil['news_id'] = $news->id;
               if ($fil['tipo'] == 'video')
                  $fil['link'] = 'https://www.youtube.com/embed/' . explode('&', explode('=', $fil['link'])[1])[0];
               $file = new File($fil);
               $file->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se registro la noticia correctamente.'], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      } else {
         return;
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $news
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(int $id, Request $request)
   {
      if ($request->ajax()) {
         try {
            $course_id = (int) $request->session()->get('course');
            $news = News::where(['estado' => 1, 'tipo' => 'Grupal', 'course_id' => $course_id])->get();
            foreach ($news as $item) {
               $item->files = File::where('news_id', $item->id)->get();
            }
            return response()->json($news, 200);
         } catch (\Throwable $th) {
            return response()->json([], 200);
         }
      } else {
         return;
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  News  $news
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(News $news, Request $request)
   {
      if ($request->ajax()) {
         $news = ($news != null && $news->estado == 0) ? null : $news;
         return response()->json($news, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  News  $news
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, News $news)
   {
      if ($request->ajax()) {
         try {
            $files = $news->files()->get();
            foreach ($files as $file) {
               $file->delete();
            }
            $newsarray = $request->all();
            $files = $request->input('files');
            $news->titulo = $newsarray['titulo'];
            $news->descripcion = $newsarray['descripcion'];
            $news->contenido = $newsarray['contenido'];
            $news->save();
            foreach ($files as $fil) {
               $fil['news_id'] = $news->id;
               $file = new File($fil);
               $file->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se actualizo la noticia correctamente.'], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      } else {
         return;
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  News  $news
    * @return \Illuminate\Http\Response
    */
   public function destroy(News $news, Request $request)
   {
      if ($request->ajax()) {
         $news->estado = 0;
         $news->save();
         return response()->json(['type' => 'success', 'message' => 'La noticia fue eliminada exitosamente'], 200);
      }
   }
}
