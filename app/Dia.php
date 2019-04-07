<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
   public function asignacioncursoprofesor()
   {
      return $this->belongsTo('Campus\AsignacionCursoProfesor');
   }
}
