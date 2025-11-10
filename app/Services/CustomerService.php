<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Service Layer para o CRUD de Clientes.
 * Recebe dados PRÉ-VALIDADOS do Controller e é responsável pela lógica de persistência e busca.
 */
class CustomerService
{
    /**
     * Retorna os clientes paginados.
     * @param int $perPage Número de itens por página.
     * @return LengthAwarePaginator
     */
    public function getPaginatedCustomers(int $perPage = 10): LengthAwarePaginator
    {
        return Customer::latest()->paginate($perPage);
    }

    /**
     * Cria um novo cliente.
     * @param array $data Dados PRÉ-VALIDADOS do Controller.
     * @return Customer O cliente recém-criado.
     */
    public function createCustomer(array $data): Customer
    {
        // Persiste no banco
        return Customer::create($data);
    }

    /**
     * Encontra um cliente pelo ID.
     * @param int $id ID do cliente.
     * @return Customer
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findCustomer(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    /**
     * Atualiza um cliente existente.
     * @param Customer $customer Instância do modelo a ser atualizado.
     * @param array $data Dados PRÉ-VALIDADOS.
     * @return bool Resultado da operação de update.
     */
    public function updateCustomer(Customer $customer, array $data): bool
    {
        // Persiste no banco
        return $customer->update($data);
    }

    /**
     * Remove um cliente.
     * @param int $id ID do cliente a ser removido.
     * @return bool Resultado da operação de delete.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteCustomer(int $id): bool
    {
        $customer = $this->findCustomer($id);
        return $customer->delete();
    }
}