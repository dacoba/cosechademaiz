<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimuladorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simuladors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_simulacion');
            $table->double('problemas');
            $table->double('altura');
            $table->double('humedad');
            $table->double('rendimiento');
            $table->string('tipo');
            $table->integer('siembra_id')->nullable()->unsigned();
            $table->foreign('siembra_id')->references('id')->on('siembras')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('planificacionriego_id')->nullable()->unsigned();
            $table->foreign('planificacionriego_id')->references('id')->on('planificacionriegos')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('planificacionfumigacion_id')->nullable()->unsigned();
            $table->foreign('planificacionfumigacion_id')->references('id')->on('planificacionfumigacions')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::drop('simuladors');
    }
}
