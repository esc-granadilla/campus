<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Taskhistory extends Model
{
   public function task()
   {
      return $this->belongsTo(Task::class);
   }

   public function student()
   {
      return $this->belongsTo(Student::class);
   }

   public function course()
   {
      return $this->belongsTo(Course::class);
   }
}
