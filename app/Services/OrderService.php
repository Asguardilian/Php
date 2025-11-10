<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Cria um novo pedido (Order) e seus itens (OrderItems) em uma transação.
     * @param array $data Dados validados do pedido (inclui customer_id, status e order_items).
     * @return Order
     */
    public function createOrder(array $data): Order
    {
        // Usa uma transação para garantir que Order e OrderItems sejam salvos juntos.
        return DB::transaction(function () use ($data) {
            
            // 1. Cria o Pedido Principal (na tabela 'orders')
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'status' => $data['status'] ?? 'pendente', 
            ]);

            // 2. Processa e associa os itens
            // Mapeia os dados validados de 'order_items' para objetos OrderItem
            $orderItemsData = collect($data['order_items'])->map(function ($item) {
                return new OrderItem([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            });
            
            // 3. Salva todos os itens de uma vez e os associa ao pedido
            $order->orderItems()->saveMany($orderItemsData);

            return $order;
        });
    }

    /**
     * Atualiza o pedido e sincroniza seus itens.
     * @param Order $order A instância do pedido a ser atualizada.
     * @param array $data Dados validados para o pedido e seus itens.
     * @return Order
     */
    public function updateOrder(Order $order, array $data): Order
    {
         return DB::transaction(function () use ($order, $data) {
             
            // 1. Atualiza os dados principais do pedido
            $order->update([
                'customer_id' => $data['customer_id'],
                'status' => $data['status'],
            ]);

            // 2. Remove todos os itens antigos para sincronizar
            $order->orderItems()->delete();

            // 3. Adiciona os novos itens
            $orderItemsData = collect($data['order_items'])->map(function ($item) {
                return new OrderItem([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            });

            $order->orderItems()->saveMany($orderItemsData);

            return $order;
        });
    }
    
    /**
     * Obtém todos os pedidos (para o index do Controller).
     */
    public function getAllOrders()
    {
        return Order::with('customer')->orderBy('id', 'desc')->get();
    }
}