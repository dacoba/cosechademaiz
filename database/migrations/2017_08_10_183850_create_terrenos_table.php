<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerrenosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terrenos', function (Blueprint $table) {
            $table->increments('id');
            $table->double('area_parcela');
            $table->string('tipo_suelo');
            $table->string('tipo_relieve');
            $table->string('estado');
            $table->integer('productor_id')->unsigned();
            $table->foreign('productor_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('terrenos');
    }
}
