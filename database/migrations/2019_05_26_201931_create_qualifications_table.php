<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('qualifications', function (Blueprint $table) {
         $table->increments('id');
         $table->string('titulo')->nullable(false);
         $table->decimal('valor_porcentual', 6, 2)->nullable(false);
         $table->decimal('porcentaje_obtenido', 6, 2)->nullable(false);
         $table->string('tipo')->nullable(false);
         $table->string('condicion')->default('realizada')->nullable(false);
         $table->string('descripcion')->nullable(true);
         $table->integer('trimestre')->nullable(false);
         $table->date('fecha')->nullable(false);
         $table->boolean('estado')->default(1)->nullable(false);
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
      Schema::dropIfExists('qualifications');
   }
}
