<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('products.index') }}">Minha Loja</a>
        
        <!-- Botão para mobile: aparece quando o menu está colapsado -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Bloco que contém todos os itens do menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                {{-- LINKS EXISTENTES --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('customers.index') }}">Clientes</a></li>
                
                {{-- NOVOS LINKS --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categorias</a></li>
                {{-- CORREÇÃO: Removido 'fw-bold text-info' para não ficar azul --}}
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Pedidos</a></li>
            </ul>
        </div>
        
    </div>
</nav>

{{-- Container para o conteúdo de cada página --}}
<div class="container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>