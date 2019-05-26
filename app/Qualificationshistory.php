<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Qualificationshistory extends Model
{
   public function student()
   {
      return $this->hasOne(Student::class);
   }

   public function course()
   {
      return $this->hasOne(Course::class);
   }

   public function qualification()
   {
      return $this->belongsTo(Qualification::class);
   }
}
