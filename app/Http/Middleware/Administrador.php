<?php

namespace Campus\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Session;
use Closure;

class Administrador
{
   protected $auth;
   public function __construct(Guard $auth)
   {
      $this->auth = $auth;
   }
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   public function handle($request, Closure $next)
   {
      if (!$this->auth->user()->hasRole('Administrador')) {
         return $this->auth->user()->authorizeRoles('Administrador');
      }
      return $next($request);
   }
}
