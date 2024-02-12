<div class="space-y-8">

    {{-- Not ideal solution  --}}
    {{-- @foreach ($post as $post)
        <livewire:post-item :post="$post" wire:key='{{ $post->id }}' />
    @endforeach --}}
    

    {{-- Ideal solution  --}}
    @for($chunk = 0; $chunk < $page; $chunk++)
        {{-- var_dump($chunks[$chunk]) --}}
        <livewire:post-chunk :ids="$chunks[$chunk]" :key="$chunk" :chunk="$chunk">

    @endfor

    @if($this->hasMorePages())
        {{-- <button wire:click='incrementPage'>Increment</button> --}}
        <div x-data x-intersect="$wire.incrementPage"></div> 
    @endif
</div>
