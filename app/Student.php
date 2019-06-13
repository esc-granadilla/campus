<?php

namespace Campus;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

   protected $fillable = [
      'cedula', 'nombre', 'primer_apellido', 'segundo_apellido', 'fecha_nacimiento', 'adecuacion', 'foto',
   ];

   public function __construct(array $array = null)
   {
      if ($array == null) {
         $this->cedula = '';
         $this->nombre = '';
         $this->primer_apellido = '';
         $this->segundo_apellido = '';
         $this->fecha_nacimiento = null;
         $this->adecuacion = '';
         $this->foto = 'none';
      } else {
         parent::__construct($array);
      }
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

   public function taskhistories()
   {
      return $this->hasMany(Taskhistory::class);
   }
}
