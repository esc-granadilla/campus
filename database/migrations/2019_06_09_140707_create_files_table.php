<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('files', function (Blueprint $table) {
         $table->increments('id');
         $table->string('titulo', 255)->nullable(false);
         $table->string('tipo', 100)->nullable(false);
         $table->string('link', 1000)->nullable(false);
         $table->integer('news_id')->unsigned()->nullable(false);
         $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
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
      Schema::dropIfExists('files');
   }
}
