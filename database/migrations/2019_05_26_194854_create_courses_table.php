<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('courses', function (Blueprint $table) {
         $table->increments('id');
         $table->string('nombre')->nullable(false);
         $table->integer('teacher_id')->unsigned();
         $table->integer('section_id')->unsigned()->nullable(false);
         $table->integer('subject_id')->unsigned()->nullable(false);
         $table->unique(['teacher_id', 'section_id', 'subject_id'], 'course_unique');
         $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
         $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
         $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
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
      Schema::dropIfExists('courses');
   }
}
