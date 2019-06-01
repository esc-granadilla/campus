<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
   public function student()
   {
      return $this->belongsTo(Student::class);
   }

   public function course()
   {
      return $this->belongsTo(Course::class);
   }
}
