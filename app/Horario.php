<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
   public function cursos()
   {
      return $this->belongsToMany('Campus\Curso');
   }
}
