<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   public function questions()
   {
      return $this->hasMany(Question::class);
   }

   public function taskhistories()
   {
      return $this->hasMany(Taskhistory::class);
   }
}
