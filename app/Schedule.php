<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
   public function sections()
   {
      return $this->hasMany(Section::class);
   }
}
