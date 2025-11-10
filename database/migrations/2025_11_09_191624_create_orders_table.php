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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        
        // Chave Estrangeira: Liga o Pedido ao Cliente (Obrigatório para o Controller!)
        $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
        
        // O Controller do seu amigo não usa 'total_amount' ou 'order_date' no 'store'
        // Mas vamos adicionar campos importantes para um pedido:
        $table->date('order_date')->useCurrent(); 
        $table->string('status', 50)->default('Pendente');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
