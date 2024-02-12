<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PostChunk extends Component
{
    // Note! Not ideal solution
    #[Reactive]
    public array $ids;

    public function render()
    {
        return view('livewire.post-chunk', [
            'posts' => Post::latest()->whereIn('id', $this->ids)
                //->orderByRaw("FIELD(id, " . implode(',', $this->ids) . ")") // Note! This is for MySQL only
                ->get(),
        ]);
    }
}
