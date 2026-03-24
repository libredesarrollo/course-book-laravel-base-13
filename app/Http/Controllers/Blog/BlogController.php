<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;

use Illuminate\Support\Facades\Cache;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('posted','yes')->paginate(2);
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if (Cache::has('post_show_' . $post->id)) {
            return Cache::get('post_show_' . $post->id);
        } else {
            $cacheView = view('blog.show', ['post' => $post])->render();
            Cache::put('post_show_' . $post->id, $cacheView);
            return $cacheView;
        }

        return cache()->rememberForever('post_show_' . $id, function () use ($id) {
            $post = Post::with('category')->find($id);
            return view('blog.show', ['post' => $post])->render();
        });

        return view('blog.show', compact('post'));
    }

}
