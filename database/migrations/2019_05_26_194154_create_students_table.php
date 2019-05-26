<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('students', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('cedula')->nullable(false);
         $table->string('nombre')->nullable(false);
         $table->string('primer_apellido')->nullable(false);
         $table->string('segundo_apellido')->nullable(false);
         $table->date('fecha_nacimiento')->nullable(false);
         $table->string('adecuacion')->nullable(false);
         $table->integer('user_id')->unsigned()->nullable(false);
         $table->integer('guardian_id')->unsigned()->nullable(true);
         $table->integer('section_id')->unsigned()->nullable(true);
         $table->boolean('estado')->default(1)->nullable(false);
         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('guardian_id')->references('id')->on('guardians')->onDelete('cascade');
         $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
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
      Schema::dropIfExists('students');
   }
}
