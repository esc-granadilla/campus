<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
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

   public function user()
   {
      return $this->belongsTo('Campus\User');
   }

   public function encargado()
   {
      return $this->hasOne('Campus\Encargado');
   }

   public function asignacioncursoprofesors()
   {
      return $this->belongsToMany('Campus\Asignacioncursoprofesor');
   }

   public function asignacionnotas()
   {
      return $this->belongsToMany('Campus\Asignacionnota');
   }
}
