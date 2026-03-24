<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Http\Controllers\Controller;

use App\Http\Requests\Category\PutRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function all()
    {
        return response()->json(Category::get());
    }
    public function index(): JsonResponse
    {
        return response()->json(Category::paginate(10));
    }
     public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json(Category::create($request->validated()), 201);
    }
    public function update(PutRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());
        return response()->json($category);
    }
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        // return response()->json("ok");
        return response()->json(['message' => 'Post eliminado'], 204);
    }
}
