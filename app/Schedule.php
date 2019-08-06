<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
   protected $fillable = [
      'desde', 'hasta'
   ];

   public function sections()
   {
      return $this->hasMany(Section::class);
   }
}
