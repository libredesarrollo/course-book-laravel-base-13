<?php

namespace App\View\Components\Blog\Post;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Post;

class Show extends Component
{
    public $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function changeTitle() : void {
        $this->post->title = 'New Title';
    }
  
    public function render(): View
    {
        return view('components.blog.post.show');
    }
}
