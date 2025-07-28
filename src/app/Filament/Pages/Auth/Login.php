<?php

namespace App\Filament\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
{
    public function mount(): void
    {
        parent::mount();

        $this->form->fill([
            'email' => 'demo@solutionforest.net',
            'password' => '12345678',
            'remember' => true,
        ]);
    }
}
