<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionCursoProfesorEstudianteTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('asignacion_curso_profesor_estudiante', function (Blueprint $table) {
         $table->integer('asignacioncursoprofesor_id')->unsigned();
         $table->integer('estudiante_id')->unsigned();
         $table->primary(['asignacioncursoprofesor_id', 'estudiante_id'], 'asignacioncursoprofesor_estudiante_primary');
         $table->foreign('asignacioncursoprofesor_id', 'asignacioncursoprofesor_foreign')->references('id')->on('asignacion_curso_profesors')->onDelete('cascade');
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
      Schema::dropIfExists('asignacion_curso_profesor_estudiante');
   }
}
