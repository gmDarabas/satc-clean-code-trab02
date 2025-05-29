<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arquivo_pasta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arquivo_id')->constrained('arquivos')->onDelete('cascade');
            $table->foreignId('pasta_id')->constrained('pastas')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['arquivo_id', 'pasta_id']);
            $table->index('pasta_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arquivo_pasta');
    }
};
