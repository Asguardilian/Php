<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // CORREÇÃO 1: Nome da tabela deve ser no plural (products)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // CORREÇÃO 2: Adiciona a coluna category_id (chave estrangeira)
            // unsignedBigInteger é o tipo correto para IDs de outras tabelas
            $table->unsignedBigInteger('category_id'); 
            
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            
            // CORREÇÃO 3: Adiciona a coluna stock (que você está validando)
            $table->integer('stock')->default(0);

            $table->timestamps();

            // Define a chave estrangeira
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories') // Assume que sua tabela de categorias chama-se 'categories'
                  ->onDelete('cascade'); // Opcional: deleta produtos se a categoria for excluída
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // CORREÇÃO: Usa o nome no plural
        Schema::dropIfExists('products');
    }
};