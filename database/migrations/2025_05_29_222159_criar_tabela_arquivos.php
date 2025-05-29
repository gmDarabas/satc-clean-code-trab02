<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nome_original');
            $table->text('descricao')->nullable();
            $table->string('hash_info')->unique(); // info_hash do torrent
            $table->string('caminho'); // caminho no MinIO
            $table->bigInteger('tamanho'); // tamanho em bytes
            $table->integer('seeds')->default(0);
            $table->integer('leechers')->default(0);
            $table->integer('downloads')->default(0);
            $table->boolean('ativo')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['hash_info', 'ativo']);
            $table->index(['usuario_id', 'ativo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arquivos');
    }
};
