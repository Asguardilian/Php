@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Categorias</h1>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Botão para Adicionar Categoria (leva para a rota create) --}}
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Adicionar Categoria</a>
        
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th width="280px">Ações</th>
            </tr> 
        </thead>
        <tbody>
            {{-- A variável $categories vem do CategoryController::index() --}}
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->nome }}</td> 
                    <td>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">Nenhuma categoria cadastrada.</td> 
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Links de Paginação (se o Controller usar ->paginate()) --}}
    {{ $categories->links() }} 
</div>
@endsection