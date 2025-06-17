<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Se você usa soft deletes

class Presenca extends Model
{
    use HasFactory;
    // use SoftDeletes; // Descomente se você usa soft deletes para presenças

    
    protected $fillable = [
        'cliente_id', // ESTE CAMPO É O MAIS IMPORTANTE AGORA
        'entrada',
        'saida',
        // Adicione outros campos se você os estiver usando no seu formulário ou lógica de criação/atualização
    ];


    // Define o relacionamento com o model Clientes
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id', 'id'); // Adicionado chaves explicitamente por segurança
    }
}
