<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
   protected $fillable = [
      'titulo', 'valor_porcentual', 'porcentaje_obtenido', 'tipo', 'condicion',
      'descripcion', 'trimestre', 'fecha', 'course_id', 'student_id'
   ];

   public function student()
   {
      return $this->belongsTo(Student::class);
   }

   public function course()
   {
      return $this->belongsTo(Course::class);
   }
}
