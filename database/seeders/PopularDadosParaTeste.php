<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Arquivo;
use App\Models\Pasta;
use Illuminate\Support\Facades\Hash;

class PopularDadosParaTeste extends Seeder
{
    public function run(): void
    {
        // Criar um usuário
        $user = User::create([
            'name' => 'Usuário Teste',
            'email' => 'teste@example.com',
            'password' => Hash::make('senha123'),
        ]);

        // Criar algumas pastas (uma raiz e subpastas)
        $pastaRaiz = Pasta::create([
            'nome' => 'Documentos',
            'descricao' => 'Pasta raiz de documentos',
            'publica' => true,
            'user_id' => $user->id,
            'pasta_pai_id' => null,
        ]);

        $subpasta1 = Pasta::create([
            'nome' => 'Projetos',
            'descricao' => 'Subpasta de projetos',
            'publica' => false,
            'user_id' => $user->id,
            'pasta_pai_id' => $pastaRaiz->id,
        ]);

        $subpasta2 = Pasta::create([
            'nome' => 'Imagens',
            'descricao' => 'Subpasta de imagens',
            'publica' => true,
            'user_id' => $user->id,
            'pasta_pai_id' => $pastaRaiz->id,
        ]);

        // Criar arquivos
        for ($i = 1; $i <= 5; $i++) {
            $arquivo = Arquivo::create([
                'nome' => "Arquivo {$i}",
                'nome_original' => "arquivo_original_{$i}.txt",
                'descricao' => "Descrição do arquivo {$i}",
                'hash_info' => md5("arquivo{$i}"),
                'caminho' => "caminho/arquivo{$i}.txt",
                'tamanho' => rand(1000, 1000000),
                'seeds' => rand(0, 10),
                'leechers' => rand(0, 5),
                'downloads' => rand(0, 100),
                'ativo' => true,
                'user_id' => $user->id,
            ]);

            // Associar a uma ou mais pastas
            $arquivo->pastas()->attach([
                $pastaRaiz->id,
                rand(0, 1) ? $subpasta1->id : $subpasta2->id,
            ]);
        }
    }
}
