<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   public function __construct()
   {
      $this->cedula = '';
      $this->nombre = '';
      $this->primer_apellido = '';
      $this->segundo_apellido = '';
      $this->fecha_nacimiento = null;
      $this->adecuacion = '';
   }

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

   public function qualifications()
   {
      return $this->hasMany(Qualification::class);
   }
}
