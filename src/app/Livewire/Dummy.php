<?php

namespace App\Livewire;

use Filament\Notifications\Notification;
use Livewire\Component;

class Dummy extends Component
{
    public $count = 1;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }

    public function resetCount()
    {
        $this->count = 1;
    }

    public function submit()
    {
        Notification::make()
            ->title('Submitted')
            ->body("Count is {$this->count}")
            ->success()
            ->send();
    }

    public function render()
    {
        return <<<'HTML'
        <div style="padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
            <h1>Dummy Component</h1>
            <p>This is a dummy component to demonstrate Livewire functionality.</p>
            <br/>
            <div style="display: flex; gap: 10px;">
                <button wire:click="increment">+</button>
                <span>{{ $this->count }}</span>
                <button wire:click="decrement">-</button>
            </div>
            <div style="display: flex; gap: 10px;">
                <button wire:click="resetCount">Refresh</button>
                <button wire:click="submit" type="submit">Submit</button>
            </div>
        </div>
        HTML;
    }
}
