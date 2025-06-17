<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Valor extends Model
{
    use HasFactory;

    // Nome da tabela no banco de dados
    protected $table = 'valores';

    // Campos que podem ser preenchidos via create() ou fill()
    protected $fillable = ['tipo', 'descricao', 'preco'];

    // Relacionamento muitos-para-muitos com Cliente
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'clientes_valor', 'valor_id', 'cliente_id');
    }
}
