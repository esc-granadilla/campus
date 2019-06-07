<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
   protected $fillable = [
      'task_id', 'pregunta', 'opcion_a', 'opcion_b', 'opcion_c', 'opcion_d',
   ];

   public function task()
   {
      return $this->belongsTo(Task::class);
   }
}
