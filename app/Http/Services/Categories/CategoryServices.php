<?php
namespace App\Http\Services\Categories;

use App\Models\Categories\Category;
use Illuminate\Support\Facades\Auth;

class CategoryServices
{
    public static function makeCategory($request)
    {
        $category = Category::create([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        return $category;
    }
    public static function updateCategory($request, Category $category)
    {
        $category->name = $request['name'];
        $category->description = $request['description'];

        if ($category->save()) {
            return $category;
        }

        return null;
    }

    public static function deleteCategory($category)
    {
        $category->delete();

        return $category;
    }

}