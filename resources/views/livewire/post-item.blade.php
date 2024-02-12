<div class="flex items-start pb-8 space-x-5 border-b border-slate-200">
    <div class="w-12 shrink-0">
        <img src="{{ $post->user->avatarUrl()}}" class="w-12 h-12 rounded-full"/>
    </div>
    <div class="space-y-2 grow">
        <div class="text-lg font-bold">{{ $post->id }} {{ $post->user->name }}</div>
        <div>
            <p>{{ $post->body }}</p>
        </div>
        <div class="flex items-center space-x-2">
            @can('delete', $post)
                <div>
                    <button class="text-indigo-500" wire:click="deletePost({{ $post->id}})">Delete</button>
                </div>
            @endcan
        </div>
    </div>
</div>
