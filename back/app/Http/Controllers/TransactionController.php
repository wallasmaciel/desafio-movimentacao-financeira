<?php

namespace App\Http\Controllers;

use App\Models\TransactionModel;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index() 
    {
        $transactions = TransactionModel::orderByDesc("created_at")->get();
        $transactions->load("category");
        // 
        return response()->json($transactions);
    }

    public function create(Request $request)
    {
        $user_id = $request->auth->sub->id;
        $validatedData = $request->validate([
            "category_id" => "required|uuid",
            "description" => "required|max:300",
            "ammount" => "required|numeric|min:0",
        ]);
        // 
        $category = TransactionModel::create([
            ...$validatedData,
            "user_id" => $user_id
        ]);
        $category->refresh();
        // 
        return response()->json($category, 201);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            "category_id" => "sometimes|uuid",
            "description" => "sometimes|max:300",
            "ammount" => "sometimes|numeric|min:0",
        ]);
        // 
        $category = TransactionModel::findOrFail($id);
        $category->update($validatedData);
        $category->refresh();
        // 
        return response()->json($category, 201);
    }

    public function show(string $id)
    {
        $transactions = TransactionModel::findOrFail($id);
        $transactions->load("category");
        // 
        return response()->json($transactions);
    }

    public function remove(string $id)
    {
        $category = TransactionModel::findOrFail($id);
        $category->delete();
        // 
        return response()->json(null, 204); // 204: No Content
    }
}
