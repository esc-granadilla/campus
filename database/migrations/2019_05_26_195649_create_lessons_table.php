<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('lessons', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('course_id')->unsigned();
         $table->integer('schedule_id')->unsigned();
         $table->integer('day_id')->unsigned();
         $table->unique(['course_id', 'schedule_id', 'day_id'], 'lesson_unique');
         $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
         $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
         $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
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
      Schema::dropIfExists('lessons');
   }
}
