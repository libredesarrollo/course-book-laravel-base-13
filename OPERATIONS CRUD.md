<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //: View
    {
        //$category = Category::find(3);
        // dd($category->posts()->where('posted', 'yes')->get());
        // dd($category->posts()->where('id', 4)->get());
        // $post = Post::find(2);
        // dd($post->category()->find(2));
        // echo Category::get();
        //  echo Category::all();

        //  dd(Category::get());
        // dd(Post::get());
        // dd(Category::first());
        // dd(Category::where('id', 2)->first());
        // // dd(Category::where('id', 2)
        // //     ->where('title', 'Cate 1')->toSql());
        // dd(Category::find(1)); //->toSql()

        // select * from categorias
        // select * from categorias where id = 1
        Category::create([
            'title' => 'Cate 4',
            'slug' => 'cate-4'
        ]);
       return view('welcome',['name' => 'John ']);
    //    return Response('asasas');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Post::create(
            ['title' => "test",
             'slug' => "test",
             'content' => "test",
             'category_id' => 3,
             'description' => "test",
             'posted' => "not",
             'image' => "test"]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(int $post)
    public function edit(Post $post)
    {
        echo $post;
        $post->update([
             'title' => "test new",
             'slug' => "test",
             'content' => "test",
            //  'category_id' => 1,
            //  'description' => "test",
            //  'posted' => "not",
            //  'image' => "test"
           
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        dd($category->delete());
    }
}



Route::get('/post', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create']);
// Route::get('/post/{post}', [PostController::class, 'edit']);
// Route::get('/post/{post:int}', [PostController::class, 'edit']);
Route::get('/post/{post}', [PostController::class, 'edit']);
Route::get('/post/delete/{category}', [PostController::class, 'destroy']);