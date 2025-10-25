@extends('layout')

@section('content')

<div class="container mt-4">
    <h1>{{ isset($customer) ? 'Editar Cliente' : 'Adicionar Cliente' }}</h1> 
    
    <form action="{{ isset($customer) ?
    route('customers.update', $customer->id) :
    route('customers.store')}}"
    method="POST">
    @csrf

    @if (isset($customer))
        @method('PUT')
    @endif

    {{-- 1. CAMPO NOME (CORRIGIDO: 'nome') --}}
    <div class="mb-3">
        <label for="nome" class="form-label"><b>Nome</b></label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ $customer->nome ?? '' }}" required>
    </div>

    {{-- 2. CAMPO CPF --}}
    <div class="mb-3">
        <label for="cpf" class="form-label"><b>CPF</b></label>
        <input type="text" name="cpf" id="cpf" class="form-control" value="{{ $customer->cpf ?? '' }}">
    </div>

    {{-- 3. CAMPO EMAIL --}}
    <div class="mb-3">
        <label class="form-label" for="email"><b>Email</b></label>
        <input type="email" id="email" name="email" class="form-control"
        value="{{ $customer->email ?? '' }}" required />
    </div>

    {{-- 4. CAMPO TELEFONE (CORRIGIDO: 'telefone') --}}
    <div class="mb-3">
        <label class="form-label" for="telefone"><b>Telefone</b></label>
        <input type="text" id="telefone" name="telefone" class="form-control"
        value="{{ $customer->telefone ?? '' }}" />
    </div>
    
    {{-- 5. CAMPO DATA DE NASCIMENTO (NOVO CAMPO!) --}}
    <div class="mb-3">
        <label class="form-label" for="data_nascimento"><b>Data de Nascimento</b></label>
        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control"
        value="{{ $customer->data_nascimento ?? '' }}" />
    </div>


    {{-- 6. CAMPO ENDEREÇO --}}
    <div class="mb-3">
        <label for="address" class="form-label"><b>Endereço</b></label>
        <input type="text" class="form-control" id="address" name="address"
                value="{{ $customer->address ?? '' }}">
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a class="btn btn-secondary" href="{{ route('customers.index') }}"> Voltar</a>

    </form>
</div>
@endsection
