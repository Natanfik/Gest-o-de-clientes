<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory, SoftDeletes; // Uso de SoftDeletes

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'numero', // Mapeado para 'telefone' no formulário
        'nascimento',
        'endereço', // MUITO IMPORTANTE: Este campo deve estar aqui
        'nome_crianca',
        'data_nascimento_crianca',
        'genero_crianca',
        'observacoes_crianca',
        'possui_irmao', // Se 'possui_irmao' for salvo diretamente no Cliente
    ];

    // Definição da relação com a tabela 'Valor'
    public function valores()
    {
        // Certifique-se que o nome da tabela pivot e as chaves estão corretos.
        // O Laravel geralmente espera 'cliente_valor' como pivot, 'clientes_id' e 'valor_id' como FKs.
        return $this->belongsToMany(Valor::class, 'cliente_valor', 'cliente_id', 'valor_id');
    }

}
