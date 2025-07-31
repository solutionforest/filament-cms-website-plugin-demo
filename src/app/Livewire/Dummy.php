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
            <h1 style="font-weight:var(--font-weight-bold);font-size: var(--text-xl);">Dummy Livewire</h1>
            <div style="display: flex; gap: 10px; align-items: center;">
                <button wire:click="increment">+</button>
                <span>{{ $this->count }}</span>
                <button wire:click="decrement">-</button>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <x-filament::button color="gray" size="xs" wire:click="resetCount">Refresh</x-filament::button>
                <x-filament::button color="gray" size="xs" wire:click="submit" type="submit">Submit</x-filament::button>
            </div>
        </div>
        HTML;
    }
}
