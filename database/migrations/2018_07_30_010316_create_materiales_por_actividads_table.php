<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialesPorActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiales_por_actividad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('material_id');
            $table->integer('actividad_id');
            $table->integer('cantidad')->nullable();
            $table->integer('metros')->nullable();
            $table->unique(['actividad_id','material_id']);
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
        Schema::dropIfExists('materiales_por_actividad');
    }
}
