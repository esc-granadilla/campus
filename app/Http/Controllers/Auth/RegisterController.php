<?php

namespace Campus\Http\Controllers\Auth;

use Campus\User;
use Campus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Campus\Encargado;
use Campus\Estudiante;
use Campus\Role;
use Campus\Profesor;

class RegisterController extends Controller
{
   /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

   use RegistersUsers;

   /**
    * Where to redirect users after registration.
    *
    * @var string
    */
   protected $redirectTo = '/home';

   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('guest');
   }

   /**
    * Get a validator for an incoming registration request.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
   protected function validator(array $data)
   {
      return Validator::make($data, [
         'name' => 'required|string|max:32',
         'email' => 'required|string|email|max:255|unique:users',
         'password' => 'required|string|min:6|confirmed',
         'cedula' => 'required|string|min:9|max:9',
         'nombre' => 'required|string|min:3|max:50',
         'primer_apellido' => 'required|string|min:3|max:80',
         'segundo_apellido' => 'required|string|min:3|max:80',
         'fecha_nacimiento' => ' required',
      ]);
   }

   /**
    * Create a new user instance after a valid registration.
    *
    * @param  array  $data
    * @return \Campus\User
    */
   protected function create(array $data)
   {
      $role = Role::where('nombre', 'Usuario')->first();
      $user = User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'password' => bcrypt($data['password']),
      ]);

      $user->roles()->attach($role);

      $idencargado = null;

      if (array_key_exists('encargado_cedula', $data)) {
         $encargado = new Encargado();
         $encargado->cedula = $data['encargado_cedula'];
         $encargado->nombre = $data['encargado_nombre'];
         $encargado->primer_apellido = $data['encargado_apellido1'];
         $encargado->segundo_apellido = $data['encargado_apellido2'];
         $encargado->parentesco = $data['encargado_parentesco'];
         $encargado->telefono = $data['encargado_telefono'];
         $encargado->email = $data['encargado_email'];
         $encargado->save();
         $idencargado = $encargado->id;
      }

      $estudiante = new Estudiante();
      $estudiante->cedula = $data['cedula'];
      $estudiante->nombre = $data['nombre'];
      $estudiante->primer_apellido = $data['primer_apellido'];
      $estudiante->segundo_apellido = $data['segundo_apellido'];
      $estudiante->fecha_nacimiento = $data['fecha_nacimiento'];
      $estudiante->grado = $data['grado'];
      $estudiante->adecuacion = $data['adecuacion'];
      $estudiante->encargado_id = $idencargado;
      $estudiante->estado = 1;

      $user->estudiante()->save($estudiante);
      return $user;
   }
}
