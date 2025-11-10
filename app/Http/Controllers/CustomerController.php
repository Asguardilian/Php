<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService; // Importa o novo Service
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Necessário para a regra unique no update

class CustomerController extends Controller
{
    protected $customerService;

    // 1. Injeção de Dependência no construtor
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Exibe a lista de clientes com paginação.
     */
    public function index(Request $request)
    {
        // Delega a busca e paginação para o Service
        $customers = $this->customerService->getPaginatedCustomers(10); 
        
        return view('customers.index', compact('customers'))
               ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Mostra o formulário para criar um novo cliente.
     */
    public function create()
    {
        return view('customers.create_update');
    }

    /**
     * Valida e salva um novo cliente no banco de dados.
     */
    public function store(Request $request)
    {
        // Valida os dados (idealmente com StoreCustomerRequest)
        $validatedData = $this->validateCustomerData($request);
        
        // Delega a criação para o Service
        $this->customerService->createCustomer($validatedData);
        
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Mostra os detalhes de um cliente específico (usando Route Model Binding).
     */
    public function show(Customer $customer)
    {
        // O Laravel já injeta o Customer, mas vamos garantir que ele está sendo usado
        // return view('customers.show', compact('customer'));
        return 'O id do usuário é: ' . $customer->id;
    }

    /**
     * Mostra o formulário para editar um cliente.
     */
    public function edit(Customer $customer)
    {
        // O Route Model Binding já injetou $customer
        return view('customers.create_update', compact('customer'));
    }

    /**
     * Atualiza um cliente existente no banco de dados.
     */
    public function update(Request $request, Customer $customer)
    {
        // Valida os dados, ignorando o ID atual para unicidade
        $validatedData = $this->validateCustomerData($request, $customer->id);
        
        // Delega a atualização para o Service
        $this->customerService->updateCustomer($customer, $validatedData);
        
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove um cliente do banco de dados.
     */
    public function destroy(Customer $customer)
    {
        // Delega a remoção para o Service
        $this->customerService->deleteCustomer($customer->id);
        
        return redirect()->route('customers.index')
                         ->with('success', 'Cliente excluído com sucesso!');
    }

    /**
     * Método auxiliar para centralizar as regras de validação.
     * @param Request $request Instância da requisição.
     * @param int|null $ignoreId ID para ignorar na regra 'unique'.
     * @return array Dados validados.
     */
    protected function validateCustomerData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'nome' => 'required|string|max:150',
            // Usa Rule::unique para lidar com o ignoreId de forma mais limpa
            'email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignore($ignoreId),
            ],
            'telefone' => 'nullable|string|max:20',
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('customers', 'cpf')->ignore($ignoreId),
            ],
            'data_nascimento' => 'nullable|date',
            'address' => 'nullable|string',
        ]);
    }
}
