<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreparacionterrenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preparacionterrenos', function (Blueprint $table) {
            $table->increments('id');
            $table->double('ph');
            $table->double('plaga_suelo');
            $table->double('drenage');
            $table->double('erocion');
            $table->double('maleza_preparacion');
            $table->string('comentario_preparacion');
            $table->string('estado');
            $table->integer('terreno_id')->unsigned();
            $table->foreign('terreno_id')->references('id')->on('terrenos')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('tecnico_id')->unsigned();
            $table->foreign('tecnico_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('preparacionterrenos');
    }
}
