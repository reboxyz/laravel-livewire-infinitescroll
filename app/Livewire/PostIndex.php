<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\On;
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

    /* Sample only
    // Event listener on 'echo' which is 'posts' channel with 'Example' event
    #[On('echo:posts,Example')]
    public function exampleBroadcast()
    {
        dd('Event listener works!!!');
    }
    */

    public function incrementPage()
    {
        $this->page++;
    }

    public function hasMorePages()
    {
        return $this->page < count($this->chunks);
    }

    // Event listener for Websocket, on echo's posts channel with PostCreated Event
    #[On('echo:posts,PostCreated')]
    public function prependPostFromBroadcast($payload)
    {
        //dd($payload);
        $this->prependPost($payload['postId']);
    }

    // Event listener
    #[On('post.created')]
    public function prependPost($postId)
    {
        if (empty($this->chunks))
        {
            $this->chunks[] = []; // initialize
        }

        // Insert to the first chunk by using the spread operator
        $this->chunks[0] = [$postId, ...$this->chunks[0]]; 

        // Note! Dispatch event signifying '0' chunk or the first chunk
        $this->dispatch('chunk.0.prepend', $postId);
    }

    // Event listener 
    #[On('post.deleted')]
    public function deletePost($postId)
    {
        // iterate all chunks and find the matched id that was deleted
        foreach($this->chunks as $index => $chunk)
        {
            if (($key = array_search($postId, $chunk)) !== false)
            {
                  // Note! Dispatch event signifying nth chunk which is the index (dynamic value)
                $this->dispatch('chunk.' . $index . '.delete', $key);

                unset($this->chunks[$index][$key]);
                break;
            }
        }    
    }

    // Event listener for Websocket, on echo's posts channel with PostDeleted Event
    #[On('echo:posts,PostDeleted')]
    public function deletePostFromBroadcast($payload)
    {
        //dd($payload);
        $this->deletePost($payload['postId']);
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
