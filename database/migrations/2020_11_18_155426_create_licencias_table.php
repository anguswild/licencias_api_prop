<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lic_id');
            $table->string('rut');
            $table->string('lic_cod_unidad');
            $table->string('lic_descripcion_unidad');
            $table->string('tipo_licencia');
            $table->integer('id_tipo_licencia');
            $table->string('serie');
            $table->string('folio');
            $table->date('fecha_licencia');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->integer('dias');
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
        Schema::dropIfExists('licencias');
    }
}
