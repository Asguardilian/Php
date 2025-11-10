<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService 
{
    // O seu Service deve estender de Service se for o seu padrão.
    // Se não, remova o 'extends Service' se ele não existir no seu arquivo.

    /**
     * Retorna todos os produtos com a relação de Categoria carregada.
     */
    public function getAllProductsWithCategory(): Collection
    {
        // Garante que a relação 'category' seja carregada (eager loading)
        return Product::with('category')->get();
    }

    /**
     * Cria um novo produto no banco de dados.
     */
    public function createProduct(array $data): Product
    {
        // Aqui o category_id é usado automaticamente
        return Product::create($data);
    }

    /**
     * Atualiza um produto existente.
     */
    public function updateProduct(Product $product, array $data): bool
    {
        // Aqui o category_id é usado automaticamente
        return $product->update($data);
    }

    /**
     * Remove um produto.
     */
    public function deleteProduct(Product $product): ?bool
    {
        return $product->delete();
    }
}
