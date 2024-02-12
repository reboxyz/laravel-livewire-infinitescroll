<?php

namespace App\Livewire;

use App\Events\PostDeleted;
use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;

    // Note! postId is identical with the post prop. For demo only,
    // postId is passed as param but actually redundant
    public function deletePost($postId)
    {
        $this->authorize('delete', $this->post);

        Post::find($postId)->delete();

        $this->dispatch('post.deleted', $postId);

        broadcast(new PostDeleted($postId))->toOthers();
    }

    public function render()
    {
        return view('livewire.post-item', [
            'post' => $this->post,
        ]);
    }
}
