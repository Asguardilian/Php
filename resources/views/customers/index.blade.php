@extends('layout')

@section('content')
<div class="container mt-4">
    <h1>Clientes</h1>
    
    {{-- Mensagem de Sucesso (Se houver) --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Adicionar Cliente</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Data Nasc.</th> {{-- NOVO CABEÇALHO --}}
                    <th>Ações</th> {{-- Coluna de Ações (Editar/Deletar) --}}
                </tr> 
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->nome }}</td> {{-- CORRIGIDO: de name para nome --}}
                        <td>{{ $customer->cpf }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->telefone }}</td> {{-- CORRIGIDO: de phone para telefone --}}
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->data_nascimento }}</td> {{-- NOVO CAMPO DE DADOS --}}
                        <td>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar este cliente?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;">Nenhum cliente cadastrado.</td> {{-- Colspan ajustado para 8 colunas --}}
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Adiciona links de paginação --}}
        {{ $customers->links() }} 
</div>
@endsection
