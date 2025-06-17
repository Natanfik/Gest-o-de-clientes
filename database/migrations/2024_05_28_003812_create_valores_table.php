<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('valores', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('descricao');
            $table->decimal('valor', 8, 2);
            $table->timestamps();
        });

        DB::transaction(function () {
            DB::table('valores')->insert([
                ['tipo' => 'Mensalista', 'descricao' => 'Mensal de 4 horas', 'valor' => 460.00],
                ['tipo' => 'Mensalista', 'descricao' => 'Mensal de 6 horas', 'valor' => 650.00],
                ['tipo' => 'Mensalista', 'descricao' => 'Mensal de 8 horas', 'valor' => 790.00],
                ['tipo' => 'semanal', 'descricao' => '2 vezes na semana 4 horas', 'valor' => 240.00],
                ['tipo' => 'semanal', 'descricao' => '3 vezes na semana 4 horas', 'valor' => 360.00],
                ['tipo' => 'semanal', 'descricao' => '2 vezes na semana 6 horas', 'valor' => 380.00],
                ['tipo' => 'semanal', 'descricao' => '3 vezes na semana 6 horas', 'valor' => 500.00],
                ['tipo' => 'Passaporte hora', 'descricao' => '10 horas', 'valor' => 240.00],
                ['tipo' => 'Passaporte hora', 'descricao' => '20 horas', 'valor' => 360.00],
                ['tipo' => 'Passaporte hora', 'descricao' => '30 horas', 'valor' => 480.00],
                ['tipo' => 'Passaporte hora', 'descricao' => '50 horas', 'valor' => 600.00],
                ['tipo' => 'Diária', 'descricao' => 'Seg a Sex', 'valor' => 89.90],
                ['tipo' => 'Diária', 'descricao' => 'Sáb', 'valor' => 109.90],
                ['tipo' => 'Diária', 'descricao' => 'Dom e Feriados', 'valor' => 139.90],
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valores');
    }
};
