<?php

namespace App\View\Components\Blog\Post;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Detail extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Post $post)
    {
     
    }

    public function changeTitle() : void {
        $this->post->title = 'New Title';
    }

    public function test_route($post)
    {
        //dd($post);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
       // dd($this->post);
        return view('components.blog.post.detail');
    }
}
