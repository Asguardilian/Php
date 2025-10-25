<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- NOVA LINHA
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Adicionei o HasFactory aqui
    use HasFactory; 
    
    protected $table = 'customers';

    // CAMPOS ATUALIZADOS para corresponder à sua NOVA MIGRATION
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf',
        'data_nascimento',
        'address',
    ];
}
