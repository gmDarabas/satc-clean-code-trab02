<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    protected $table = 'arquivos';

    protected $fillable = [
        'nome',
        'nome_original',
        'descricao',
        'hash_info',
        'caminho_minio',
        'tamanho',
        'seeds',
        'leechers',
        'downloads',
        'ativo',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'tamanho' => 'integer',
            'seeds' => 'integer',
            'leechers' => 'integer',
            'downloads' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function pastas()
    {
        return $this->belongsToMany(Pasta::class, 'arquivo_pasta')
            ->withTimestamps();
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeDoUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    public function scopePorHash($query, $hash)
    {
        return $query->where('hash_info', $hash);
    }

    public function getTamanhoFormatado()
    {
        $bytes = $this->tamanho;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes >= 1024 && $i < 4; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function incrementarDownloads()
    {
        $this->increment('downloads');
    }

    public function atualizarStats($seeds, $leechers)
    {
        $this->update([
            'seeds' => $seeds,
            'leechers' => $leechers,
        ]);
    }
}
