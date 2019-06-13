<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
   public function lessons()
   {
      return $this->hasMany(Lesson::class);
   }
}
