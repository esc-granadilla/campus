<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPuntajeToTaskhistoriesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('taskhistories', function (Blueprint $table) {
         $table->decimal('puntaje', 6, 2)->after('trimestre')->default(0.0);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('taskhistories', function (Blueprint $table) {
         $table->dropColumn('puntaje');
      });
   }
}
