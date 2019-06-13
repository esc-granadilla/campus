<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskhistoriesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('taskhistories', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('course_id')->unsigned();
         $table->integer('task_id')->unsigned();
         $table->integer('student_id')->unsigned();
         $table->string('inicio')->nullable(false);
         $table->string('final')->nullable(false);
         $table->integer('trimestre')->nullable(false);
         $table->boolean('estado')->default(1)->nullable(false);
         $table->unique(['course_id', 'task_id', 'student_id'], 'taskhistory_unique');
         $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
         $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
         $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
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
      Schema::dropIfExists('taskhistories');
   }
}
