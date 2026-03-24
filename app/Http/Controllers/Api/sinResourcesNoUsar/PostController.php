<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Http\Controllers\Controller;

use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function all()
    {
        return response()->json(Post::get());
    }
    public function index(): JsonResponse
    {
        return response()->json(Post::paginate(10));
    }
    public function show(Post $post): JsonResponse
    {
        return response()->json($post);
    }
    public function store(StoreRequest $request): JsonResponse
    {
        return response()->json(Post::create($request->validated()), 201);
    }
    public function update(PutRequest $request, Post $post): JsonResponse
    {
        $post->update($request->validated());
        return response()->json($post);
    }
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        // return response()->json("ok");
        return response()->json(['message' => 'Post eliminado'], 204);
    }
}
