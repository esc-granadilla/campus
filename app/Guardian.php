<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
   public function student()
   {
      return $this->belongsTo(Student::class);
   }
}
