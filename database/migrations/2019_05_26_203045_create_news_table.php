<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('news', function (Blueprint $table) {
         $table->increments('id');
         $table->string('titulo', 255)->nullable(false);
         $table->longText('descripcion')->nullable(true);
         $table->longText('contenido')->nullable(true);
         $table->string('tipo', 100)->default('Global')->nullable(false);
         $table->string('fecha')->nullable(false);
         $table->boolean('estado')->default(1)->nullable(false);
         $table->integer('course_id')->unsigned()->nullable(true);
         $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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
      Schema::dropIfExists('news');
   }
}
