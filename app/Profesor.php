<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
   public function user()
   {
      return $this->belongsTo('Campus\User');
   }

   public function asignacioncursoprofesor()
   {
      return $this->belongsTo('Campus\Asignacioncursoprofesor');
   }
}