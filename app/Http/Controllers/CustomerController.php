<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Exibe a lista de clientes com paginação.
     */
    public function index()
    {
        // CORREÇÃO DO ERRO: Usa paginate() para permitir o $customers->links() na View
        $customers = Customer::paginate(10); 
        
        // Passa uma variável 'i' para numeração sequencial (opcional)
        return view('customers.index', compact('customers'))
               ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Mostra o formulário para criar um novo cliente.
     */
    public function create()
    {
        // Assumindo que você usa 'create_update.blade.php'
        return view('customers.create_update');
    }

    /**
     * Salva um novo cliente no banco de dados com validação.
     */
    public function store(Request $request)
    {
        // Adiciona validação de segurança e regras para os novos campos
        $request->validate([
            'nome' => 'required|string|max:150',
            'email' => 'required|email|unique:customers',
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'nullable|string|max:14|unique:customers',
            'data_nascimento' => 'nullable|date',
            'address' => 'nullable|string',
        ]);
        
        Customer::create($request->all());
        
        // Adiciona mensagem de sucesso ao redirecionar
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Mostra os detalhes de um cliente específico (não precisa de alteração)
     */
    public function show(string $id)
    {
        return 'O id do usuário é: ' . $id;
    }

    /**
     * Mostra o formulário para editar um cliente.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.create_update', compact('customer'));
    }

    /**
     * Atualiza um cliente existente no banco de dados com validação.
     */
    public function update(Request $request, $id)
    {
        // Encontra o cliente
        $customer = Customer::findOrFail($id);

        // Regras de validação, ignorando o email e cpf do próprio cliente no check de unicidade
        $request->validate([
            'nome' => 'required|string|max:150',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'nullable|string|max:14|unique:customers,cpf,' . $customer->id,
            'data_nascimento' => 'nullable|date',
            'address' => 'nullable|string',
        ]);
        
        // Atualiza o registro
        $customer->update($request->all());
        
        // Adiciona mensagem de sucesso ao redirecionar
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove um cliente do banco de dados.
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        // Adiciona mensagem de sucesso ao redirecionar
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente excluído com sucesso!');
    }
}
