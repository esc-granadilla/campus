<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesorsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
      Schema::create('profesors', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('cedula')->nullable(false);
         $table->string('nombre')->nullable(false);
         $table->string('primer_apellido')->nullable(false);
         $table->string('segundo_apellido')->nullable(false);
         $table->date('fecha_nacimiento')->nullable(false);
         $table->string('puesto')->nullable(false);
         $table->date('fecha_ingreso')->nullable(true);
         $table->string('telefono1')->nullable(false);
         $table->string('telefono2')->nullable(true);
         $table->integer('user_id')->unsigned()->nullable(false);
         $table->boolean('estado')->default(1)->nullable(false);
         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         $table->timestamps();
      });
   }

   /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
   {
      Schema::dropIfExists('profesors');
   }
}
