<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostIndex extends Component
{
    /* Note! Not an ideal solution
    public int $limit = 10;

    // Note! This is working but not an ideal solution for optimization
    public function incrementPage()
    {
        $this->limit = $this->limit + 10;
    }
    */

    // Note! Ideal solution is build chunks of array and render by chunk
    public array $chunks = []; // An array of array
    
    public int $page = 1; // Current chunk page

    public function incrementPage()
    {
        $this->page++;
    }

    public function hasMorePages()
    {
        return $this->page < count($this->chunks);
    }

    
    public function mount()
    {
        $this->chunks = Post::latest()->pluck('id')->chunk(10)->toArray();
        //dd($this->chunks);
    }


    public function render()
    {
        return view('livewire.post-index', [
            'post' => Post::latest()
            //->take($this->limit)
            ->get(),
        ]);
    }
}