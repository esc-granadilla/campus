<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
   public function horarios()
   {
      return $this->belongsToMany('Campus\Horario');
   }

   public function asignacioncursoprofesor()
   {
      return $this->belongsTo('Campus\Asignacioncursoprofesor');
   }
}
