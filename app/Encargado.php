<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
   public function estudiante()
   {
      return $this->belongsTo('Campus\Estudiante');
   }
}
