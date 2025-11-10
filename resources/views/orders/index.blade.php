@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Lista de Pedidos</h1>
    
    {{-- Exibição de Mensagens de Sucesso/Erro --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success"><p>{{ $message }}</p></div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger"><p>{{ $message }}</p></div>
    @endif

    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Novo Pedido</a>
        
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Status</th>
                <th>Total (Aprox)</th>
                <th width="280px">Ações</th>
            </tr> 
        </thead>
        <tbody>
            {{-- A variável $orders é injetada pelo controller --}}
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    {{-- Usa a relação 'customer' para pegar o nome do cliente --}}
                    <td>{{ $order->customer->nome ?? 'Cliente Deletado' }}</td> 
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->status }}</td>
                    {{-- Calcula o total somando todos os itens, formatando para BRL --}}
                    <td>R$ {{ number_format($order->items->sum(fn($item) => $item->quantity * $item->unit_price), 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('ATENÇÃO: Deletar este pedido excluirá todos os seus itens. Tem certeza?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Nenhum pedido cadastrado.</td> 
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Certifique-se que o controller está usando paginate() --}} 
</div>
@endsection