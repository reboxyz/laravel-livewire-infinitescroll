<?php

namespace App\Livewire;

use App\Events\PostDeleted;
use App\Events\PostLiked;
use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{
    public Post $post;

    protected $listeners = [
        // Note! Listening to specific post only
        'posts.{post.id}.updated' => '$refresh', // Magic method to re-render this component
        'echo:posts.{post.id},PostUpdated' => '$refresh',
        'echo:posts.{post.id},PostLiked' => '$refresh',
    ];

    // Note! postId is identical with the post prop. For demo only,
    // postId is passed as param but actually redundant
    public function deletePost($postId)
    {
        $this->authorize('delete', $this->post);

        Post::find($postId)->delete();

        $this->dispatch('post.deleted', $postId);

        broadcast(new PostDeleted($postId))->toOthers();
    }

    public function like()
    {
        $this->post->increment('likes');

        // Trigger event for Websocket for others
        broadcast(new PostLiked($this->post->id))->toOthers();
    }

    public function render()
    {
        return view('livewire.post-item', [
            'post' => $this->post,
        ]);
    }
}
