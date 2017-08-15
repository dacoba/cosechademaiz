<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanificacionfumigacions2Table extends Migration
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
            $table->date('fecha_planificacion');
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
