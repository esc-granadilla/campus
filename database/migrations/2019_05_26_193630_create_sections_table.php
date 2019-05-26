<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('sections', function (Blueprint $table) {
         $table->increments('id');
         $table->string('seccion')->nullable(false);
         $table->integer('grade_id')->unsigned()->nullable(false);;
         $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
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
      Schema::dropIfExists('sections');
   }
}
