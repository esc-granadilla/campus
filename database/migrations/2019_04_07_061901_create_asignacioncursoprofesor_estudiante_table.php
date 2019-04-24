<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacioncursoprofesorEstudianteTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('asignacioncursoprofesor_estudiante', function (Blueprint $table) {
         $table->integer('asignacioncursoprofesor_id')->unsigned();
         $table->integer('estudiante_id')->unsigned();
         $table->primary(['asignacioncursoprofesor_id', 'estudiante_id'], 'asignacioncursoprofesor_estudiante_primary');
         $table->foreign('asignacioncursoprofesor_id', 'asignacioncursoprofesor_foreign')->references('id')->on('asignacioncursoprofesors')->onDelete('cascade');
         $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
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
      Schema::dropIfExists('asignacioncursoprofesor_estudiante');
   }
}
