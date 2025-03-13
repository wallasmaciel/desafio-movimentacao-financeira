<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;

use Exception;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = CategoryModel::orderByDesc("created_at")->get();
        return response()->json($categories);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|max:60",
            "description" => "required|max:300",
            "type" => "required|max:8",
        ]);
        // 
        $category = CategoryModel::create($validatedData);
        $category->refresh();
        // 
        return response()->json($category, 201);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "name" => "sometimes|max:60",
            "description" => "sometimes|max:300",
            "type" => "sometimes|max:8",
        ]);
        // 
        $category = CategoryModel::findOrFail($id);
        $category->update($validatedData);
        $category->refresh();
        // 
        return response()->json($category, 201);
    }

    public function show(string $id)
    {
        $categories = CategoryModel::findOrFail($id);
        return response()->json($categories);
    }

    public function remove(string $id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();
        // 
        return response()->json(null, 204); // 204: No Content
    }
}
