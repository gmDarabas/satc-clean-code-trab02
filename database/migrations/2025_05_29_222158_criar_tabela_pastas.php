<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('publica')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pasta_pai_id')->nullable()->constrained('pastas')->onDelete('cascade');
            $table->timestamps();

            $table->index(['user_id', 'pasta_pai_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastas');
    }
};
