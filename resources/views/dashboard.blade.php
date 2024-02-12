<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-8 text-gray-900">
                    {{-- <livewire:some-list /> --}}
                    <livewire:create-post />
                    <livewire:post-index />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
