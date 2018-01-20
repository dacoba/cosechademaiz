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
            $table->datetime('fecha_planificacion');
            $table->string('estado');
            $table->integer('metodos_riego');
            $table->integer('comportamiento_lluvia');
            $table->integer('problemas_drenaje');
            $table->boolean('email_send')->default(false);
            $table->string('comentario_riego');
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
