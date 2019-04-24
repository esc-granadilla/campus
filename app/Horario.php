<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
   public function cursos()
   {
      return $this->belongsToMany('Campus\Curso');
   }

   public function asignacioncursoprofesor()
   {
      return $this->belongsTo('Campus\Asignacioncursoprofesor');
   }

   public function asignacionnota()
   {
      return $this->belongsTo('Campus\Asignacionnota');
   }
}
