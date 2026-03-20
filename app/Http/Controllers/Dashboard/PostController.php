<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Post;
use App\Models\Category;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\PutRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::paginate(2);
        return view('dashboard.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::pluck('id', 'title');
        $post = new Post();
        return view('dashboard.post.create', compact('categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        Post::create($request->validated());
        return to_route('post.index');        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('dashboard.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(int $post)
    public function edit(Post $post): View
    {
        $categories = Category::pluck('id', 'title');
        return view('dashboard.post.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        if(isset($data['image'])){
            $data['image'] = time().'.'.$data["image"]->extension();
            $request->image->move(public_path('image'), $data['image']);
        }
        $post->update($data);
        return to_route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return to_route('post.index');
    }
}
