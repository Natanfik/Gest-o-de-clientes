<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteValorTable extends Migration
{
    public function up()
    {
        Schema::create('cliente_valor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('valor_id');
            // outras colunas se precisar
            $table->timestamps();

            // foreign keys
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('valor_id')->references('id')->on('valores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes_valor');
    }
}
