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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Liga ao Pedido (orders)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // CORREÇÃO: Referencia a tabela 'products' (plural)
            // ANTES ESTAVA 'product', AGORA ESTÁ 'products'
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
            
            // Campos de Item
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
