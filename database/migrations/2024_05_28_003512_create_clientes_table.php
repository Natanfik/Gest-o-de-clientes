<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('nascimento');
            $table->string('cpf');
            $table->string('numero');
            $table->string('endereço');
            $table->string('nome_crianca')->nullable();
            $table->date('data_nascimento_crianca')->nullable();
            $table->string('genero_crianca')->nullable();
            $table->text('observacoes_crianca')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
