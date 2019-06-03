<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
   public function teacher()
   {
      return $this->belongsTo(Teacher::class);
   }

   public function subject()
   {
      return $this->belongsTo(Subject::class);
   }

   public function section()
   {
      return $this->belongsTo(Section::class);
   }

   public function lessons()
   {
      return $this->hasMany(Lesson::class);
   }

   public function qualifications()
   {
      return $this->hasMany(Qualification::class);
   }

   public function taskhistories()
   {
      return $this->hasMany(Taskhistory::class);
   }
}
