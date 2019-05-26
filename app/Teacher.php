<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Use_;

class Teacher extends Model
{
   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function courses()
   {
      return $this->hasMany(Course::class);
   }
}
