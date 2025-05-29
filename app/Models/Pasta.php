<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasta extends Model
{
    use HasFactory;

    protected $table = 'pastas';

    protected $fillable = [
        'nome',
        'descricao',
        'publica',
        'usuario_id',
        'pasta_pai_id',
    ];

    protected function casts(): array
    {
        return [
            'publica' => 'boolean',
        ];
    }

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function pastaPai()
    {
        return $this->belongsTo(Pasta::class, 'pasta_pai_id');
    }

    public function subpastas()
    {
        return $this->hasMany(Pasta::class, 'pasta_pai_id');
    }

    public function arquivos()
    {
        return $this->belongsToMany(Arquivo::class, 'arquivo_pasta')
            ->withTimestamps();
    }

    // Scopes
    public function scopePublicas($query)
    {
        return $query->where('publica', true);
    }

    public function scopeRaiz($query)
    {
        return $query->whereNull('pasta_pai_id');
    }

    public function scopeDoUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // Métodos auxiliares
    public function getCaminhoCompleto()
    {
        $caminho = collect();
        $pasta = $this;

        while ($pasta) {
            $caminho->prepend($pasta->nome);
            $pasta = $pasta->pastaPai;
        }

        return $caminho->implode(' > ');
    }
}
