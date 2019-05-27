<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Use_;

class Teacher extends Model
{
   public function __construct()
   {
      $this->cedula = '';
      $this->nombre = '';
      $this->primer_apellido = '';
      $this->segundo_apellido = '';
      $this->fecha_nacimiento = null;
      $this->puesto = '';
      $this->fecha_ingreso = null;
      $this->telefono1 = '';
      $this->telefono2 = '';
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }

   public function courses()
   {
      return $this->hasMany(Course::class);
   }
}
