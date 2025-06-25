<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Services\Categories\CategoryServices;
use App\Models\Categories\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //

    public function index($pagination = 20)
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(20);
        return view('categories.index', compact('categories'));
    }

    public function store()
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $response = CategoryServices::makeCategory($request);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al crear la Categoria',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Categoria creada correctamente',
            'type' => 'success',
        ]);
    }
    public function update(Category $category)
    {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $response = CategoryServices::updateCategory($request, $category);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al actualizar la Categoria',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Categoria actualizada correctamente',
            'type' => 'success',
        ]);
    }
    public function delete(Category $category)
    {
        $response = CategoryServices::deleteCategory($category);

        if($response === null)
        {
            return redirect()->back()->with([
                'message' => 'Error al eliminar la Categoria',
                'type' => 'danger',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Categoria eliminada correctamente',
            'type' => 'success',
        ]);
    }
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
}
