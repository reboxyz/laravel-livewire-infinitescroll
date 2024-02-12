<div class="space-y-8">
    {{-- var_dump($ids) --}}
    @foreach ($posts as $post)
        <livewire:post-item :post="$post" wire:key='{{ $post->id }}' />
    @endforeach
</div>
