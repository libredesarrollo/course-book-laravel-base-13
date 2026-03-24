<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Http\Requests\Category\PutRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function all(): AnonymousResourceCollection
    { 
        return CategoryResource::collection(Category::all());
    }
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::paginate(10));
    }
     public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }
    public function store(StoreRequest $request): CategoryResource
    {
        return new CategoryResource(Category::create($request->validated()), 201);
    }
    public function update(PutRequest $request, Category $category): CategoryResource
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }
     
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json(['message' => 'Post eliminado'], 204);
    }
}
