<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class SomeListCount extends Component
{
    #[Reactive()]  // Note! Use sparingly coz of performance penalty
    public array $things;

    public function render()
    {
        return view('livewire.some-list-count');
    }
}
