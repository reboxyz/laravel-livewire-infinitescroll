<?php

namespace App\Livewire;

use App\Events\PostUpdated;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditPost extends Component
{
    public Post $post;
    #[Rule('required')]
    public string $body = "";

    public function mount()
    {
        $this->fill(
            $this->post->only('body')
        );
    }

    public function editPost()
    {
        $this->authorize('edit', $this->post);
        $this->validate();

        $this->post->update($this->only('body'));

        // Dynamic event which is not for Websocket but for self
        $this->dispatch('posts.' . $this->post->id . '.updated');

        // Event for Websocket to others
        broadcast(new PostUpdated($this->post->id))->toOthers();

        // Note! Trigger alpine custom event
        $this->dispatch('edit-cancel');
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
