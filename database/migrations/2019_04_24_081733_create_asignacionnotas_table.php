<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionnotasTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('asignacionnotas', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('nota_id')->unsigned();
         $table->integer('estudiante_id')->unsigned();
         $table->integer('profesor_id')->unsigned();
         $table->integer('curso_id')->unsigned();
         $table->integer('horario_id')->unsigned();
         $table->integer('grado_id')->unsigned();
         $table->integer('dia_id')->unsigned();
         $table->unique(['nota_id', 'estudiante_id', 'profesor_id', 'curso_id', 'horario_id', 'grado_id', 'dia_id'], 'asignacionnotas_primary');
         $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
         $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
         $table->foreign('profesor_id')->references('id')->on('profesors')->onDelete('cascade');
         $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
         $table->foreign('nota_id')->references('id')->on('notas')->onDelete('cascade');
         $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
         $table->foreign('dia_id')->references('id')->on('dias')->onDelete('cascade');
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
      Schema::dropIfExists('asignacionnotas');
   }
}
