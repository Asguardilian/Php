<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Service Layer para o CRUD de Categorias.
 * Responsável pela lógica de busca, persistência e, PRINCIPALMENTE, validação.
 */
class CategoryService
{
    /**
     * Retorna as categorias paginadas.
     * @param int $perPage Número de itens por página.
     * @return LengthAwarePaginator
     */
    public function getPaginatedCategories(int $perPage = 10): LengthAwarePaginator
    {
        // Lógica de busca e paginação
        return Category::latest()->paginate($perPage);
    }

    /**
     * Valida os dados da requisição e cria uma nova categoria.
     * @param array $data Dados da requisição (geralmente $request->all()).
     * @return Category A categoria recém-criada.
     */
    public function createCategory(array $data): Category
    {
        // Executa a validação antes de qualquer operação no banco
        $this->validateData($data);
        
        // Persiste no banco
        return Category::create($data);
    }

    /**
     * Valida os dados da requisição e atualiza uma categoria existente.
     * @param Category $category Instância do modelo a ser atualizado.
     * @param array $data Dados da requisição.
     * @return bool Resultado da operação de update.
     */
    public function updateCategory(Category $category, array $data): bool
    {
        // Executa a validação, passando o ID para ignorar o registro atual na regra 'unique'
        $this->validateData($data, $category->id);

        // Persiste no banco
        return $category->update($data);
    }

    /**
     * Remove uma categoria.
     * @param Category $category Instância da categoria a ser removida.
     * @return bool Resultado da operação de delete.
     */
    public function deleteCategory(Category $category): bool
    {
        // Em um sistema mais complexo, aqui poderia haver lógica de negócio
        // para, por exemplo, impedir a exclusão se a categoria estiver em uso.
        return $category->delete();
    }

    /**
     * Valida os dados da categoria usando o Facade Validator do Laravel.
     * Se falhar, dispara uma exceção que o Laravel trata para retornar o erro ao usuário.
     * @param array $data Dados a serem validados.
     * @param int|null $categoryId ID da categoria para exclusão na regra 'unique' (se for atualização).
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateData(array $data, ?int $categoryId = null): void
    {
        $rules = [
            // Regra: campo 'nome' é obrigatório, no máximo 150 caracteres, e ÚNICO na tabela 'categories'
            'nome' => [
                'required',
                'max:150',
                // Rule::unique garante que, no update, o próprio registro seja ignorado
                Rule::unique('categories')->ignore($categoryId),
            ],
            // Adicione outras regras de validação aqui se necessário
        ];

        // O método validate() dispara automaticamente uma exceção se falhar
        Validator::make($data, $rules)->validate();
    }
}