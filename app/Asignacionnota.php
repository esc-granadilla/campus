<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Asignacionnota extends Model
{
   public function horario()
   {
      return $this->hasOne('Campus\Horario');
   }
   public function curso()
   {
      return $this->hasOne('Campus\Curso');
   }
   public function dia()
   {
      return $this->hasOne('Campus\Dia');
   }
   public function grado()
   {
      return $this->hasOne('Campus\Grado');
   }
   public function profesor()
   {
      return $this->hasOne('Campus\Profesor');
   }
   public function nota()
   {
      return $this->hasOne('Campus\Nota');
   }
   public function estudiante()
   {
      return $this->hasOne('Campus\Estudiante');
   }
}
