@extends('layout')'

@section('content')
<div class="container mt-4">
    <h1>Produtos</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Adicionar Produto</a>
        
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->price }}</td>
                <td> Acoes aqui! </td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" 
                    class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('products.destroy', $product->id) }}"
                     method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
</div>

@endsection