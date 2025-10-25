@extends('layout')
@section('content')

<div class="container mt-4">
    <h1>{{ isset($product) ? 'Editar Produto' : 'Adicionar Produto' }}        
    </h1> 
    
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
        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name ?? '' }}" required>
    </div>

<div class="mb-3">
        <label for="description" class="form-label"><b>Descrição</b></label>
        <textarea name="description" id="" rows="2" class="form-control">{{ $product->description ?? '' }} </textarea>
</div>

<div class="mb-3"">
        <label class="form-label" for="price"><b>Preço</b></label>
        <input type="number"name="price" class="form-control"
        value="{{ $product->price ?? '' }}" />
</div>

<button type="submit" class="btn btn-success">Salvar</button>
<a class="btn btn-secondary" href="{{ route('products.index') }}"> Voltar</a>

</form>
    </div>
@endsection
    
