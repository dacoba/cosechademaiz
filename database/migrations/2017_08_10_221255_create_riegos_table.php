<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riegos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('metodos_riego');
            $table->integer('comportamiento_lluvia');
            $table->integer('problemas_drenaje');
            $table->string('comentario_riego');
            $table->integer('siembra_id')->unsigned();
            $table->foreign('siembra_id')->references('id')->on('siembras')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('riegos');
    }
}
