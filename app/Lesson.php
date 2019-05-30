<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;
use Campus\Schedule;

class Lesson extends Model
{
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
      'schedule_id', 'day_id', 'course_id',
   ];

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
