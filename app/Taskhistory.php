<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Taskhistory extends Model
{
   protected $fillable = [
      'course_id', 'task_id', 'student_id', 'inicio', 'final', 'trimestre',
   ];

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
