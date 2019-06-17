<?php

use Illuminate\Database\Seeder;
use Campus\Role;

class RolesTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $role1 = new Role();
      $role1->nombre = "Usuario";
      $role1->descripcion = "Otorga permisos a los Estudiantes";
      $role1->estado = 1;
      $role1->save();

      $role2 = new Role();
      $role2->nombre = "Profesor";
      $role2->descripcion = "Otroga permisos a los Maestros en el Sistema";
      $role2->estado = 1;
      $role2->save();

      $role3 = new Role();
      $role3->nombre = "Administrador";
      $role3->descripcion = "Otroga permisos a los Administradores en el Sistema";
      $role3->estado = 1;
      $role3->save();
   }
}
