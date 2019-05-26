<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
   public function sections()
   {
      return $this->hasMany(Section::class);
   }
}
