<?php

use Illuminate\Database\Seeder;
use Campus\Day;
use Campus\Grade;
use Campus\User;
use Campus\Teacher;
use Campus\Student;

class DefaultsTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $day1 = new Day();
      $day1->dia = "Lunes";
      $day1->estado = 1;
      $day1->save();

      $day2 = new Day();
      $day2->dia = "Martes";
      $day2->estado = 1;
      $day2->save();

      $day3 = new Day();
      $day3->dia = "Miercoles";
      $day3->estado = 1;
      $day3->save();

      $day4 = new Day();
      $day4->dia = "Jueves";
      $day4->estado = 1;
      $day4->save();

      $day5 = new Day();
      $day5->dia = "Viernes";
      $day5->estado = 1;
      $day5->save();

      $grade1 = new Grade();
      $grade1->grado = "Primero";
      $grade1->estado = 1;
      $grade1->save();

      $grade2 = new Grade();
      $grade2->grado = "Segundo";
      $grade2->estado = 1;
      $grade2->save();

      $grade3 = new Grade();
      $grade3->grado = "Tercero";
      $grade3->estado = 1;
      $grade3->save();

      $grade4 = new Grade();
      $grade4->grado = "Cuarto";
      $grade4->estado = 1;
      $grade4->save();

      $grade5 = new Grade();
      $grade5->grado = "Quinto";
      $grade5->estado = 1;
      $grade5->save();

      $grade6 = new Grade();
      $grade6->grado = "Sexto";
      $grade6->estado = 1;
      $grade6->save();

      $user1 = User::where('email', 'administrador@gmail.com')->first();
      $user2 = User::where('email', 'profesor@gmail.com')->first();
      $user3 = User::where('email', 'estudiante@gmail.com')->first();

      $student = new Student();
      $student->cedula = "113131313";
      $student->nombre = "David";
      $student->primer_apellido = "Campos";
      $student->segundo_apellido = "Campos";
      $student->fecha_nacimiento = "2014-06-08";
      $student->adecuacion = "Ninguna";
      $student->foto = "none";
      $student->user_id = $user3->id;
      $student->guardian_id = null;
      $student->section_id = null;
      $student->estado = 1;
      $student->save();

      $teacher1 = new Teacher();
      $teacher1->cedula = "121212129";
      $teacher1->nombre = "Marcos";
      $teacher1->primer_apellido = "Ramirez";
      $teacher1->segundo_apellido = "Perez";
      $teacher1->fecha_nacimiento = "1974-02-05";
      $teacher1->foto = "none";
      $teacher1->user_id = $user1->id;
      $teacher1->puesto = "Administrador";
      $teacher1->fecha_ingreso = "2014-05-14";
      $teacher1->telefono1 = "25454563";
      $teacher1->telefono2 = "78454563";
      $teacher1->estado = 1;
      $teacher1->save();

      $teacher2 = new Teacher();
      $teacher2->cedula = "113131313";
      $teacher2->nombre = "David";
      $teacher2->primer_apellido = "Camacho";
      $teacher2->segundo_apellido = "Camacho";
      $teacher2->fecha_nacimiento = "1973-05-09";
      $teacher2->foto = "none";
      $teacher2->user_id = $user2->id;
      $teacher2->puesto = "Profesor de Matematicas";
      $teacher2->fecha_ingreso = "2017-05-10";
      $teacher2->telefono1 = "87542114";
      $teacher2->telefono2 = "63242114";
      $teacher2->estado = 1;
      $teacher2->save();
   }
}
