<?php

namespace Campus\Http\Controllers;

use Campus\Task;
use Illuminate\Http\Request;
use Campus\Question;
use Campus\Course;

class TaskController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Tarea Controller
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
   /**
    * Display a listing of the resource.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $tareas = Task::where('estado', 1)->orderBy('created_at', 'des')->get();
         return response()->json($tareas, 200);
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
            $tarea = new Task($request->all());
            $tarea->save();
            $id = $tarea->id;
            $preguntas = $request->all()['preguntas'];
            foreach ($preguntas as $pregunta) {
               $pregunta['task_id'] = $id;
               $question = new Question($pregunta);
               $question->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se registro la tarea correctamente.'], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function show(int $id, Request $request)
   {
      if ($request->ajax()) {
         try {
            if ($id == 0) {
               $course = Course::all()->find((int) $request->session()->get('course'));
               $id = $course->subject()->first()->id;
               $tasks = Task::where(['estado' => 1, 'subject_id' => $id])->orderBy('created_at', 'des')->get();
               return response()->json($tasks, 200);
            } else {
               $task = Task::where('id', $id)->first();
               $task = ($task != null && $task->estado == 0) ? null : $task;
               return response()->json($task, 200);
            }
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  Task  $task
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function edit(Task $task, Request $request)
   {
      if ($request->ajax()) {
         $task = ($task != null && $task->estado == 0) ? null : $task;
         return response()->json($task, 200);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  Task  $task
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Task $task)
   {
      if ($request->ajax()) {
         try {
            $questions = $task->questions()->get();
            foreach ($questions as $question) {
               $question->delete();
            }
            $task->respuestas = $request->input('respuestas');
            $task->save();
            $id = $task->id;
            $preguntas = $request->all()['preguntas'];
            foreach ($preguntas as $pregunta) {
               $pregunta['task_id'] = $id;
               $question = new Question($pregunta);
               $question->save();
            }
            return response()->json(['type' => 'success', 'message' => 'Se actualizo la tarea correctamente.'], 200);
         } catch (\Throwable $th) {
            return response()->json(['type' => 'error', 'message' => $th->getMessage()], 200);
         }
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  Task  $task
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function destroy(Task $task, Request $request)
   {
      if ($request->ajax()) {
         $task->estado = 0;
         $task->save();
         return response()->json(['type' => 'success', 'message' => 'La tarea fue eliminada exitosamente'], 200);
      }
   }
}
