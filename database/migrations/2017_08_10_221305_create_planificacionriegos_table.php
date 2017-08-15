<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanificacionriegosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planificacionriegos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_alerta');
            $table->date('fecha_planificacion');
            $table->integer('riego_id')->unsigned();
            $table->foreign('riego_id')->references('id')->on('riegos')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('planificacionriegos');
    }
}
