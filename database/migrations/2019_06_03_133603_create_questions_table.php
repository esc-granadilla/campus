<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('questions', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('task_id')->unsigned();
         $table->longText('pregunta')->nullable(false);
         $table->longText('opcion_a')->nullable(false);
         $table->longText('opcion_b')->nullable(false);
         $table->longText('opcion_c')->nullable(false);
         $table->longText('opcion_d')->nullable(false);
         $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
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
      Schema::dropIfExists('questions');
   }
}
