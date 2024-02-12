<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PostChunk extends Component
{
    // Note! Not ideal solution
    // #[Reactive]  // Note! we will not use Reactive 
    public array $ids;

    public int $chunk;

    // Event listener with dynamic placeholder
    #[On('chunk.{chunk}.prepend')]
    public function prependToChunk($postId)
    {
        $this->ids = [$postId, ...$this->ids]; // Note! This is alternative to using Reactive
    }

    // Event listener with dynamic placeholder
    #[On('chunk.{chunk}.delete')]
    public function deleteFromChunk($key)
    {
        unset($this->ids[$key]); // Note! This is alternative to using Reactive
    }

    public function render()
    {
        return view('livewire.post-chunk', [
            'posts' => Post::latest()->whereIn('id', $this->ids)
                //->orderByRaw("FIELD(id, " . implode(',', $this->ids) . ")") // Note! This is for MySQL only
                ->get(),
        ]);
    }
}
