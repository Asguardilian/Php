<?php

// app/Models/OrderItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    // Relação 1: Um Item pertence a um Pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    // Relação 2: Um Item pertence a um Produto (Necessário para o Controller)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
