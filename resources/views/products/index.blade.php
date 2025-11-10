@extends('layout')

@section('content')
    {{-- Removido o <div class="container mt-4"> duplicado. Adicionado mt-3 e mb-3 ao h1 --}}
    <h1 class="mt-3 mb-3">Produtos</h1>
    
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Adicionar Produto</a>
    
    {{-- Adicionando verificação de mensagens de sessão --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th width="150px">Ações</th> {{-- Ajustado a largura para os botões --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td style="display: flex; gap: 5px;">
                    <a href="{{ route('products.edit', $product->id) }}" 
                    class="btn btn-sm btn-warning">Editar</a>
                    
                    <form action="{{ route('products.destroy', $product->id) }}"
                    method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
            {{-- Adicionando caso de tabela vazia --}}
            @empty($products)
            <tr>
                <td colspan="5" class="text-center">Nenhum produto cadastrado.</td>
            </tr>
            @endempty
        </tbody>
    </table>
@endsection