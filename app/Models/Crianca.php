<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome_crianca',
        'data_nascimento_crianca',
        'genero_crianca',
        'observacoes_crianca',];

    public function valores()
    {
        return $this->belongsToMany(Valor::class, 'crianca_id', 'cliente_valor', 'cliente_id', 'valor_id');

    }

    public function presencas()
    {
        return $this->hasMany(Presenca::class, 'crianca_id');
    }
}