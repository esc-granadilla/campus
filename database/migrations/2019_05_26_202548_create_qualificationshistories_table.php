<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationshistoriesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('qualificationshistories', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('qualification_id')->unsigned();
         $table->integer('student_id')->unsigned();
         $table->integer('course_id')->unsigned();
         $table->unique(['qualification_id', 'student_id', 'course_id'], 'qualificationshistories_unique');
         $table->foreign('qualification_id')->references('id')->on('qualifications')->onDelete('cascade');
         $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
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
      Schema::dropIfExists('qualificationshistories');
   }
}
