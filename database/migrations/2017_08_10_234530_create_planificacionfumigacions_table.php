<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanificacionfumigacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planificacionfumigacions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_alerta');
            $table->datetime('fecha_planificacion');
            $table->string('estado');
            $table->integer('preventivo_plagas');
            $table->integer('control_rutinario');
            $table->integer('control_malezas');
            $table->integer('control_insectos');
            $table->integer('control_enfermedades');
            $table->boolean('email_send')->default(false);
            $table->string('comentario_fumigacion');
            $table->integer('fumigacion_id')->unsigned();
            $table->foreign('fumigacion_id')->references('id')->on('fumigacions')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('planificacionfumigacions');
    }
}
