<?php

namespace Campus;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
   use Notifiable;

   public function roles()
   {
      return $this->belongsToMany('Campus\Role');
   }

   public function estudiante()
   {
      return $this->hasOne('Campus\Estudiante');
   }

   public function profesor()
   {
      return $this->hasOne('Campus\Profesor');
   }

   public function authorizeRoles($roles)
   {
      if ($this->hasAnyRole($roles)) {
         return true;
      }
      abort(401, 'Esta accion no esta autorizada');
   }

   public function hasAnyRole($roles)
   {
      if (is_array($roles)) {
         foreach ($roles as $role) {
            if ($this->hasRole($role)) {
               return true;
            }
         }
      } else {
         return $this->hasRole($roles);
      }
      return false;
   }

   public function hasRole($role)
   {
      if ($this->roles()->where('nombre', $role)->first()) {
         return true;
      }
      return false;
   }
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
      'name', 'email', 'password',
   ];

   /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   protected $hidden = [
      'password', 'remember_token',
   ];
}
