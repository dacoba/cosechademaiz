<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cosechas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('problemas_produccion');
            $table->integer('altura_tallo');
            $table->integer('humedad_terreno');
            $table->integer('rendimiento_produccion');
            $table->string('comentario_cosecha');
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
        Schema::drop('cosechas');
    }
}
