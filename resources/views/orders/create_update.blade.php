@extends('layout')

@section('content')

<div class="container mt-4">
    <h1>{{ isset($order) ? 'Editar Pedido #' . $order->id : 'Criar Novo Pedido' }}</h1> 
    
    <form id="orderForm" action="{{ isset($order) ? route('orders.update', $order->id) : route('orders.store')}}" method="POST">
    @csrf

    @if (isset($order))
        @method('PUT')
    @endif
    
    {{-- Exibir erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Verifique os erros e a tabela de itens.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    {{-- Exibir erro do Controller (Transação) --}}
    @if (Session::get('error'))
        <div class="alert alert-danger">
            <p><strong>Erro no Pedido:</strong> {{ Session::get('error') }}</p>
        </div>
    @endif

    {{-- DADOS GERAIS DO PEDIDO --}}
    <div class="row mb-4">
        {{-- Cliente --}}
        <div class="col-md-6">
            <label for="customer_id" class="form-label"><b>Cliente</b></label>
            <select class="form-control" id="customer_id" name="customer_id" required>
                <option value="">Selecione o Cliente</option>
                {{-- A variável $customers deve ser injetada pelo controller --}}
                @foreach ($customers as $customer) 
                    <option value="{{ $customer->id }}" 
                        {{ (isset($order) && $order->customer_id == $customer->id) || old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->nome }} (CPF: {{ $customer->cpf }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div class="col-md-6">
            <label for="status" class="form-label"><b>Status</b></label>
            @php
                $statuses = ['Pendente', 'Processando', 'Enviado', 'Concluido', 'Cancelado'];
                $currentStatus = $order->status ?? old('status', 'Pendente');
            @endphp
            <select class="form-control" id="status" name="status" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ $currentStatus == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <hr>
    
    <h2>Itens do Pedido</h2>
    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th width="35%">Produto</th>
                <th width="20%">Preço Unitário (R$)</th>
                <th width="15%">Quantidade</th>
                <th width="15%">Subtotal (R$)</th>
                <th width="10%">Ação</th>
            </tr>
        </thead>
        <tbody>
            {{-- Linhas serão adicionadas aqui por JS e PHP (na edição) --}}
            @if(isset($order) && $order->items->count() > 0)
                @foreach ($order->items as $index => $item)
                    {{-- Usa JS para calcular e exibir o subtotal --}}
                    <tr data-index="{{ $index }}">
                        <td>
                            <select class="form-control product-select" name="items[{{ $index }}][product_id]" onchange="updateRow(this)" required>
                                <option value="">Selecione um produto</option>
                                {{-- A variável $products deve ser injetada pelo controller --}}
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price }}" 
                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (R$ {{ number_format($product->price, 2, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control item-price" 
                                   name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" 
                                   onchange="updateRow(this)" required>
                        </td>
                        <td>
                            <input type="number" class="form-control item-quantity" 
                                   name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" 
                                   min="1" onchange="updateRow(this)" required>
                        </td>
                        <td class="item-subtotal">
                            R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remover</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><b>Total do Pedido:</b></td>
                <td colspan="2" id="orderTotal">R$ 0,00</td>
            </tr>
        </tfoot>
    </table>
    
    <button type="button" class="btn btn-info mb-3" onclick="addRow()">Adicionar Item</button>
    <br>
    
    <button type="submit" class="btn btn-success">Salvar Pedido</button>
    <a class="btn btn-secondary" href="{{ route('orders.index') }}"> Voltar</a>

    </form>
</div>

<script>
    // Carrega a lista de produtos do PHP para JS para fácil acesso
    const productsData = @json($products->keyBy('id')); 
    
    let itemIndex = {{ isset($order) ? $order->items->count() : 0 }}; 

    // Função para adicionar uma nova linha à tabela
    function addRow(product_id = '', quantity = 1, unit_price = 0) {
        const tableBody = document.querySelector('#itemsTable tbody');
        const newRow = tableBody.insertRow();
        newRow.setAttribute('data-index', itemIndex);

        const template = `
            <td>
                <select class="form-control product-select" name="items[${itemIndex}][product_id]" onchange="updateRow(this)" required>
                    <option value="">Selecione um produto</option>
                    ${Object.values(productsData).map(p => `
                        <option value="${p.id}" data-price="${p.price}" ${product_id == p.id ? 'selected' : ''}>
                            ${p.name} (R$ ${parseFloat(p.price).toFixed(2).replace('.', ',')})
                        </option>
                    `).join('')}
                </select>
            </td>
            <td>
                <input type="number" step="0.01" class="form-control item-price" 
                       name="items[${itemIndex}][unit_price]" value="${unit_price}" 
                       onchange="updateRow(this)" required>
            </td>
            <td>
                <input type="number" class="form-control item-quantity" 
                       name="items[${itemIndex}][quantity]" value="${quantity}" 
                       min="1" onchange="updateRow(this)" required>
            </td>
            <td class="item-subtotal">R$ 0,00</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remover</button>
            </td>
        `;

        newRow.innerHTML = template;
        
        // Se for uma linha nova, atualiza os campos e o total
        if (!product_id) {
            updateRow(newRow.querySelector('.product-select'));
        } else {
            updateOrderTotal();
        }

        itemIndex++;
    }

    // Função para remover uma linha
    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
        updateOrderTotal();
    }

    // Função para atualizar o preço unitário e o subtotal da linha
    function updateRow(element) {
        const row = element.closest('tr');
        const productSelect = row.querySelector('.product-select');
        const priceInput = row.querySelector('.item-price');
        const quantityInput = row.querySelector('.item-quantity');
        const subtotalCell = row.querySelector('.item-subtotal');
        
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        
        // 1. Atualiza o preço se o produto mudar
        if (element === productSelect) {
            const defaultPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            priceInput.value = defaultPrice.toFixed(2);
        }

        const price = parseFloat(priceInput.value) || 0;
        const quantity = parseInt(quantityInput.value) || 0;
        
        const subtotal = price * quantity;
        
        subtotalCell.innerHTML = `R$ ${subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        
        updateOrderTotal();
    }

    // Função para calcular e exibir o total geral do pedido
    function updateOrderTotal() {
        let total = 0;
        const rows = document.querySelectorAll('#itemsTable tbody tr');
        
        rows.forEach(row => {
            const priceInput = row.querySelector('.item-price');
            const quantityInput = row.querySelector('.item-quantity');
            
            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            
            total += price * quantity;
        });

        const orderTotalElement = document.getElementById('orderTotal');
        orderTotalElement.innerHTML = `R$ ${total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // Inicializa o total ao carregar a página
    window.onload = function() {
        updateOrderTotal();
        
        // Se não houver itens pré-carregados (modo criação), adiciona uma linha vazia
        if ({{ isset($order) ? 'false' : 'true' }} && document.querySelectorAll('#itemsTable tbody tr').length === 0) {
            addRow();
        }
    }
</script>
@endsection
    
