<div class="flex items-start pb-8 space-x-5 border-b border-slate-200">
    <div class="w-12 shrink-0">
        <img src="{{ $post->user->avatarUrl()}}" class="w-12 h-12 rounded-full"/>
    </div>
    <div class="space-y-2 grow">
        <div class="text-lg font-bold">{{ $post->id }} {{ $post->user->name }}</div>
        {{-- Note! In alpine.js, define an 'editing' boolean variable  --}}
        <div x-data="{ editing: false }" x-on:edit-cancel="editing = false">
            <div class="space-y-4" x-show="!editing">
                <p>{{ $post->body }}</p>
            
                <div class="flex items-center space-x-2">
                    @can('edit', $post)
                        <div>
                            <button class="text-indigo-500" x-on:click="editing = true">Edit</button>
                        </div>
                    @endcan

                    @can('delete', $post)
                        <div>
                            <button class="text-indigo-500" wire:click="deletePost({{ $post->id}})">Delete</button>
                        </div>
                    @endcan
                </div>
            </div>
            {{-- Note! x-cloak is defined is app.css which is to eliminate flickering --}}
            <div x-show="editing" x-cloak>
                <livewire:edit-post :post="$post">
            </div>
        </div>
    </div>
    <div class="flex items-start self-stretch shrink-0">
        <button class="flex items-center px-3 py-1 rounded-lg bg-slate-100" wire:click="like">{{ $post->likes }}</button>
    </div>

</div>
