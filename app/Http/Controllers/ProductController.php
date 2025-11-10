<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Exibe a lista de produtos.
     */
    public function index()
    {
        // Chamada ao Service para a lógica de busca
        $products = $this->productService->getAllProductsWithCategory(); 
        return view('products.index', compact('products'));
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create()
    {
        // Busca todas as categorias para o <select>
        $categories = Category::all();
        return view('products.create_update', compact('categories'));
    }
    
    /**
     * Armazena um novo recurso. (Com Validação no Controller)
     */
    public function store(Request $request) 
    {
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            // Validação CRUCIAL da categoria: required e deve existir em 'categories'
            'category_id' => 'required|integer|exists:categories,id', 
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0', 
        ]);

        // Envia apenas os dados validados para o Service
        $this->productService->createProduct($validatedData);

        return redirect()->route('products.index')->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Exibe um recurso específico.
     */
    public function show(string $id)
    {
        return 'O id do produto é: ' . $id;
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Product $product) 
    {
        // Busca todas as categorias para o <select>
        $categories = Category::all();
        return view('products.create_update', compact('product', 'categories'));
    }

    /**
     * Atualiza o recurso específico. (Com Validação no Controller)
     */
    public function update(Request $request, Product $product)
    {
        // Validação dos dados de entrada (Unique ignora o ID atual)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,'.$product->id,
            'description' => 'nullable|string',
            // Validação da categoria
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        
        // Envia apenas os dados validados para o Service
        $this->productService->updateProduct($product, $validatedData);
        
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove o recurso específico.
     */
    public function destroy(Product $product) 
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso!');
    }
}
