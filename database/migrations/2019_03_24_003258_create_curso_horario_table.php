<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursoHorarioTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
      Schema::create('curso_horario', function (Blueprint $table) {
         $table->integer('curso_id')->unsigned();
         $table->integer('horario_id')->unsigned();
         $table->primary(['curso_id', 'horario_id']);
         $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
         $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
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
      Schema::dropIfExists('curso_horario');
   }
}
