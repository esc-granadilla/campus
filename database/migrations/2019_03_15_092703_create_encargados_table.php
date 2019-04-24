<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncargadosTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
      Schema::create('encargados', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('cedula')->nullable(false);
         $table->string('nombre')->nullable(false);
         $table->string('primer_apellido')->nullable(false);
         $table->string('segundo_apellido')->nullable(false);
         $table->string('parentesco')->nullable(false);
         $table->string('telefono')->nullable(true);
         $table->string('email')->nullable(false);
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
      Schema::dropIfExists('encargados');
   }
}
