<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFallaPorActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('falla_por_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actividad_id');
            $table->integer('falla_id');
            $table->timestamps();
            $table->unique(['actividad_id','falla_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('falla_por_actividades');
    }
}
