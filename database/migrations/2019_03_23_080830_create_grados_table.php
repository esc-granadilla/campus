<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradosTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
      Schema::create('grados', function (Blueprint $table) {
         $table->increments('id');
         $table->string('grado')->nullable(false);
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
      Schema::dropIfExists('grados');
   }
}
