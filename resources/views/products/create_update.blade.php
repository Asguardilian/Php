@extends('layout')
@section('content')

<div class="container mt-4">
    <h1>{{ isset($product) ? 'Editar Produto' : 'Adicionar Produto' }}</h1> 
    
    <form action="{{ isset($product) ?
    route('products.update', $product->id) :
    route('products.store')}}"
    method="POST">
    @csrf

    @if (isset($product))
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label"><b>Nome</b></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    </div>

    {{-- NOVO CAMPO: Seleção de Categoria (category_id) --}}
    <div class="mb-3">
        <label for="category_id" class="form-label"><b>Categoria</b></label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="" disabled selected>Selecione uma categoria</option>
            {{-- Itera sobre as categorias passadas pelo Controller --}}
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{-- Marca a categoria atual ao editar ou após erro de validação (old) --}}
                    @if (isset($product) && $product->category_id == $category->id)
                        selected
                    @elseif (old('category_id') == $category->id)
                        selected
                    @endif
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label"><b>Descrição</b></label>
        <textarea name="description" id="description" rows="2" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="price"><b>Preço</b></label>
        {{-- Adiciona step="0.01" para permitir decimais na validação do navegador --}}
        <input type="number"
               name="price"
               class="form-control"
               step="0.01" 
               value="{{ old('price', $product->price ?? '') }}" />
        @error('price')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="stock"><b>Estoque</b></label>
        <input type="number"
               name="stock"
               class="form-control"
               value="{{ old('stock', $product->stock ?? '') }}" />
        @error('stock')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('products.index') }}"> Voltar</a>

    </form>
</div>
@endsection

    
