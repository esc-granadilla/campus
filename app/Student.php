<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   public function guardian()
   {
      return $this->hasOne(Guardian::class);
   }

   public function section()
   {
      return $this->belongsTo(Section::class);
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function qualificationshistories()
   {
      return $this->hasMany(Qualificationshistory::class);
   }
}
