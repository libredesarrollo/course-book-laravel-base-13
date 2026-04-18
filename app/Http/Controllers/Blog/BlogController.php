<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOMeta;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('posted', 'yes')->paginate(2);
        
        SEOMeta::setTitle('Blog');
        SEOMeta::setCanonical(route('blog.index'));

        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        SEOMeta::setTitle($post->title);
        SEOMeta::setCanonical(route('blog.show', $post->slug));

        return cache()->rememberForever('post_show_'.$post->id, function () use ($post) {
            return view('blog.show', ['post' => $post])->render();
        });
    }
}
