@extends('layout')

@section('content')

<div class="container mt-4">
    {{-- Título muda se a variável $category existir (edição) --}}
    <h1>{{ isset($category) ? 'Editar Categoria' : 'Adicionar Categoria' }}</h1> 
    
    <form action="{{ isset($category) ?
    route('categories.update', $category->id) :
    route('categories.store')}}"
    method="POST">
    @csrf

    @if (isset($category))
        @method('PUT')
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Verifique os erros.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CAMPO NOME --}}
    <div class="mb-3">
        <label for="nome" class="form-label"><b>Nome da Categoria</b></label>
        <input type="text" class="form-control" id="nome" name="nome" 
               value="{{ $category->nome ?? old('nome') }}" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('categories.index') }}"> Voltar</a>

    </form>
</div>
@endsection
    
