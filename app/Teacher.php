<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Use_;

class Teacher extends Model
{
   protected $fillable = [
      'cedula', 'nombre', 'primer_apellido', 'segundo_apellido', 'fecha_nacimiento',
      'puesto', 'fecha_ingreso', 'telefono1', 'telefono2', 'foto',
   ];

   public function __construct(array $array = null)
   {
      if ($array == null) {
         $this->cedula = '';
         $this->nombre = '';
         $this->primer_apellido = '';
         $this->segundo_apellido = '';
         $this->fecha_nacimiento = null;
         $this->puesto = '';
         $this->fecha_ingreso = null;
         $this->telefono1 = '';
         $this->telefono2 = '';
         $this->foto = 'none';
      } else {
         parent::__construct($array);
      }
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
