<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
   protected $fillable = [
      'seccion', 'grade_id'
   ];

   public function grade()
   {
      return $this->belongsTo(Grade::class);
   }

   public function students()
   {
      return $this->hasMany(Student::class);
   }

   public function courses()
   {
      return $this->hasMany(Course::class);
   }
}
