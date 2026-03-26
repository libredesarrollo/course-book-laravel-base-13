<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Mail\SubscribeEmail;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if(!Auth::user()->hasPermissionTo('editor.post.index')){
            return abort(403);
        }
        // dd(hello2('Andres'));
        // $posts = Post::with('category')->paginate(20);
        $posts = Post::paginate(20);

        // Mail::to('no-reply@example.net.com')
        //     ->send(new SubscribeEmail('contact@gmail.com', 'SUPER PROMO', '<h1>VIVA LA PATRIA<h1><p>Hola loKito!</p>'));

        //         Log::emergency("LOGS!!");
        // Log::alert("LOGS!!");
        // Log::critical("LOGS!!");
        // Log::error("LOGS!!");
        // Log::warning("LOGS!!");
        // Log::notice("LOGS!!");
        // Log::info("LOGS!!");
        // Log::debug("LOGS!!");
        // dd(config('custom'));
        return view('dashboard.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

   

        $categories = Category::pluck('id', 'title');
        $post = new Post;

        return view('dashboard.post.create', compact('categories', 'post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        // $post = Post::create($request->validated());

        // $post = new Post($request->validated());
        // auth()->user()->posts()->save($post);

        auth()->user()->posts()->save(new Post($request->validated()));

        return to_route('post.index')->with('status', 'Registro Creado');
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

        // en los GATES
        // if(!Gate::allows('update-post', $post)){
        //     abort(403);
        // }

        // Politica
        if (! Gate::allows('update', $post)) {
            abort(403, 'FUERA DE AQUI YANKI!!');
        }

        // dd(Gate::check('create', $post));
        // dd(Gate::any(['create','update'], $post));
        // dd(Gate::none(['create','update'], $post));
        // dd(auth()->user()->can('create', $post));
        // dd(auth()->user()->cannot('create', $post));

        // Gate::allowIf(fn(User $user) => $user->id < 0);

        // dd(Gate::inspect('update', $post)->message());
        // if (!Gate::allows('update', $post)) {
        // $res = Gate::inspect('update', $post);
        // if (!$res->allowed()) {
        //     return abort(403, $res->message());
        // }

        // Gate::authorize('update', $post);

        $categories = Category::pluck('id', 'title');

        return view('dashboard.post.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PutRequest $request, Post $post): RedirectResponse
    {

        if (! Gate::allows('update', $post)) {
            return abort(403);
        }

        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = time().'.'.$data['image']->extension();
            $request->image->move(public_path('image'), $data['image']);
        }
        Cache::forget('post_show_'.$post->id);
        $post->update($data);

        return to_route('post.index')->with('status', 'Registro Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        if (! Gate::allows('delete', $post)) {
            return abort(403);
        }
        $post->delete();

        return to_route('post.index')->with('status', 'Registro Eliminado');
    }
}
