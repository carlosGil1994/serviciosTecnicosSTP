<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('propiedad_id');
            $table->timestamp('fecha_ini');
            $table->timestamp('fecha_fin')->nullable();
            $table->text('descripcion');
            $table->string('estado');
            $table->integer('creador_id');
            $table->integer('tecnico_id')->nullable();
            $table->integer('cancelador_id')->nullable();
            $table->text('comentario')->nullable();
            $table->integer('servicio_id');
            $table->boolean('cierre_cliente')->default(false);
            $table->boolean('cierre_tecnico')->default(false);
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
        Schema::dropIfExists('orden_servicios');
    }
}
