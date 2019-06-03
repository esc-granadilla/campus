<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
   public function task()
   {
      return $this->belongsTo(Task::class);
   }
}
