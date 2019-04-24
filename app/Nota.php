<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
   public function asignacionnota()
   {
      return $this->belongsTo('Campus\Asignacionnota');
   }
}
