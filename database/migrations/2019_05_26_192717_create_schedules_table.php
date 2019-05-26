<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('schedules', function (Blueprint $table) {
         $table->increments('id');
         $table->string('desde')->nullable(false);
         $table->string('hasta')->nullable(false);
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
      Schema::dropIfExists('schedules');
   }
}
