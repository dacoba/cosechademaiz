<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFumigacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fumigacions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('preventivo_plagas');
            $table->integer('control_rutinario');
            $table->integer('control_malezas');
            $table->integer('control_insectos');
            $table->integer('control_enfermedades');
            $table->string('comentario_fumigacion');
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
        Schema::drop('fumigacions');
    }
}
