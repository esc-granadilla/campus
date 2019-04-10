<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticiasTable extends Migration
{
    
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo',255);
            $table->longText('descripcion');
            $table->string('links_attachments',1000);
            $table->timestamps();
         });
    }

    
    public function down()
    {
        Schema::dropIfExists('asignacioncursoprofesor_estudiante');
    }
}
