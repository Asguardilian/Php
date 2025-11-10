<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_date',
        'status',
    ];

    // Relação 1: Um Pedido pertence a um Cliente (Necessário para o Controller)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relação 2: Um Pedido tem muitos Itens (Necessário para o Controller)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
