<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
// IMPORTANTE: 1. Importa o Service
use App\Services\OrderService;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request; 

class OrderController extends Controller
{
    // 2. Declara a propriedade para guardar a instância do Service
    protected $orderService;

    // 3. Construtor: Injeta a dependência do Service
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // O Controller chama o Service para buscar os dados
        $orders = $this->orderService->getAllOrders();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create_update', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     * O Controller está MAGRO: Apenas chama o Service para a lógica principal.
     */
    public function store(StoreOrderRequest $request) 
    {
        // Chamamos o método do Service para fazer todo o trabalho complexo de criação
        $this->orderService->createOrder($request->validated());

        return redirect()->route('orders.index')->with('success', 'Pedido criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.product']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('orderItems');
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create_update', compact('order', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOrderRequest $request, Order $order)
    {
        // Chamamos o Service para fazer a complexa atualização e sincronização de itens
        $this->orderService->updateOrder($order, $request->validated());

        return redirect()->route('orders.index')->with('success', 'Pedido atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Remove os itens e o pedido
        $order->orderItems()->delete();
        $order->delete();
        
        return redirect()->route('orders.index')->with('success', 'Pedido excluído com sucesso!');
    }
}