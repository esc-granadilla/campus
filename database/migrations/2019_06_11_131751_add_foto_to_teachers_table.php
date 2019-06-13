<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFotoToTeachersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('teachers', function (Blueprint $table) {
         $table->string('foto')->after('telefono2')->default('none');
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::table('teachers', function (Blueprint $table) {
         $table->dropColumn('foto');
      });
   }
}
