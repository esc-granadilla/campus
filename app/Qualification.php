<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
   public function qualificationshistory()
   {
      return $this->hasOne(Qualificationshistory::class);
   }
}
