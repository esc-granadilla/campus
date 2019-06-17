<?php

use Illuminate\Database\Seeder;
use Campus\Role;
use Campus\User;

class UsersTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      $role1 = Role::where('nombre', 'Administrador')->first();
      $role2 = Role::where('nombre', 'Profesor')->first();
      $role3 = Role::where('nombre', 'Usuario')->first();

      $user1 = new User();
      $user1->name = "administrador";
      $user1->email = "administrador@gmail.com";
      $user1->password = bcrypt('12345678');
      $user1->save();
      $user1->roles()->attach($role1);
      $user1->roles()->attach($role2);

      $user2 = new User();
      $user2->name = "profesor";
      $user2->email = "profesor@gmail.com";
      $user2->password = bcrypt('12345678');
      $user2->save();
      $user2->roles()->attach($role2);

      $user3 = new User();
      $user3->name = "estudiante";
      $user3->email = "estudiante@gmail.com";
      $user3->password = bcrypt('12345678');
      $user3->save();
      $user3->roles()->attach($role3);
   }
}
