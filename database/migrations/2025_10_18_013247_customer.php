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
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('nome', 150); // Mudei de 'name' para 'nome'
        $table->string('email', 150)->unique(); // Garantindo que o email seja único e não nulo
        $table->string('telefone', 20)->nullable();
        $table->string('cpf', 14)->nullable()->unique(); // CPF, se preenchido, será único
        $table->date('data_nascimento')->nullable(); // NOVO CAMPO
        $table->text('address')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::dropIfExists('customers');
    }
};
