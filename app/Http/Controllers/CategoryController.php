<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService; // Importa o Service
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    // Construtor: Injeta a dependência do Service
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Exibe a lista de categorias.
     */
    public function index(Request $request)
    {
        // 1. Delega a busca e paginação para o Service
        $categories = $this->categoryService->getPaginatedCategories(10);
        
        return view('categories.index', compact('categories'))
             // 2. Calcula o índice da página baseado no Request, como antes.
             ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Mostra o formulário de criação. (CORRIGIDO: usa view única)
     */
    public function create()
    {
        // MUDANÇA AQUI: Usa a view 'categories.create_update'
        return view('categories.create_update'); 
    }

    /**
     * Armazena um novo recurso.
     */
    public function store(Request $request)
    {
        // Delega a criação E A VALIDAÇÃO para o Service
        $this->categoryService->createCategory($request->all());
        
        return redirect()->route('categories.index')
                         ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Mostra o formulário de edição (usa Route Model Binding). (CORRIGIDO: usa view única)
     */
    public function edit(Category $category)
    {
        // MUDANÇA AQUI: Usa a view 'categories.create_update'
        return view('categories.create_update', compact('category')); 
    }

    /**
     * Atualiza o recurso específico.
     */
    public function update(Request $request, Category $category)
    {
        // Delega a atualização E A VALIDAÇÃO para o Service
        $this->categoryService->updateCategory($category, $request->all());
        
        return redirect()->route('categories.index')
                         ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove o recurso específico.
     */
    public function destroy(Category $category)
    {
        // Delega a remoção para o Service
        $this->categoryService->deleteCategory($category);
        
        return redirect()->route('categories.index')
                         ->with('success', 'Categoria deletada com sucesso!');
    }
}
