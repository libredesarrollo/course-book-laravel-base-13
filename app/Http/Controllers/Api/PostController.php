<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;

use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function all():AnonymousResourceCollection
    {
        return PostResource::collection(Post::get());
    }
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::paginate(10));
    }
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }
    public function store(StoreRequest $request): PostResource
    {
        return new PostResource(Post::create($request->validated()), 201);
    }
    public function update(PutRequest $request, Post $post): PostResource
    {
        $post->update($request->validated());
        return new PostResource($post);
    }
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();
        return response()->json(['message' => 'Post eliminado'], 204);
    }
}
