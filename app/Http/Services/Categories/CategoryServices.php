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
    public static function updateCategory($category, $request)
    {
        $category->update([
            'name' => $request['name'],
            'description' => $request['description'],
        ]);

        return $category;
    }
    public static function deleteCategory($category)
    {
        $category->delete();

        return $category;
    }

}