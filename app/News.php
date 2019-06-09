<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
   protected $guarded = [];

   public function news()
   {
      return $this->belongsTo(Course::class);
   }

   public function files()
   {
      return $this->hasMany(File::class);
   }
}
