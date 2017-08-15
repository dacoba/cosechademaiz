<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiembrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siembras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('semilla');
            $table->integer('fertilizacion');
            $table->integer('densidad_siembra');
            $table->string('comentario_siembra');
            $table->integer('preparacionterreno_id')->unsigned();
            $table->foreign('preparacionterreno_id')->references('id')->on('preparacionterrenos')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('siembras');
    }
}
