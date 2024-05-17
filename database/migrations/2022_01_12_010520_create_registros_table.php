<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->integer('nroDoc');
            $table->date('fechaEntregaCmte');
            $table->date('fechaEntrega');
            $table->string('procedenciaDoc');
            $table->string('numeroDoc');
            $table->string('objetoDoc');
            $table->string('tipoDoc');
            $table->string('observacionesDoc');
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
        Schema::dropIfExists('registros');
    }
}
