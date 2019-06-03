<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('tasks', function (Blueprint $table) {
         $table->increments('id');
         $table->string('titulo')->nullable(false);
         $table->longText('descripcion')->nullable(false);
         $table->decimal('valor', 6, 2)->nullable(false);
         $table->longText('respuestas')->nullable(false);
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
      Schema::dropIfExists('tasks');
   }
}
