<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DenunciasMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncias', function(Blueprint $table){
        $table->increments('id');
        $table->string('titulo');
        $table->string('autor');
        $table->double('latitud');
        $table->double('longitud');
        $table->string('direccion');
        $table->integer('usuario_id')->unsigned();
        
        $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
