<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposPorActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_por_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('equipo_id');
            $table->integer('actividad_id');
            $table->integer('cantidad');
            $table->unique(['actividad_id','equipo_id']);
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
        Schema::dropIfExists('equipos_por_actividad');
    }
}
