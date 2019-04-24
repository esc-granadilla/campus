<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
   public function asignacioncursoprofesor()
   {
      return $this->belongsTo('Campus\Asignacioncursoprofesor');
   }

   public function asignacionnotas()
   {
      return $this->belongsToMany('Campus\Asignacionnota');
   }
}
