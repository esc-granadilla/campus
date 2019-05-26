<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Scheduling\Schedule;

class Lesson extends Model
{
   public function day()
   {
      return $this->belongsTo(Day::class);
   }

   public function schedule()
   {
      return $this->belongsTo(Schedule::class);
   }

   public function course()
   {
      return $this->belongsTo(Course::class);
   }
}
