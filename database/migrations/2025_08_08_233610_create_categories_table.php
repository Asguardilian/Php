<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Este método cria a tabela 'categories'.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // A coluna 'name' é essencial para identificarmos a categoria
            $table->string('name')->unique(); 
            // Opcional: Adicionar uma breve descrição
            $table->text('description')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Este método remove a tabela 'categories'.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
