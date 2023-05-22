<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CodeWrapper extends Component
{
    public ?string $content = null;

    public function render()
    {
        return view('livewire.code-wrapper');
    }
}
