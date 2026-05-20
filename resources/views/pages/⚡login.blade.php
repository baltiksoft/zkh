<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts.empty')]
#[Title('Вход в систему')]
class extends Component {

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public function mount()
    {
        // It is logged in
        if (auth()->user()) {
            return redirect(route('home'));
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth()->attempt($credentials)) {
            session()->regenerate();

            return redirect()->intended(route('home'));
        }

        $this->addError('email', __('auth.failed'));
    }
}
?>


<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10">
        <x-app-brand />
    </div>

    <x-form wire:submit="login">
        <x-input placeholder="{{ __('auth.email') }}" wire:model="email" icon="o-envelope" />
        <x-input placeholder="{{ __('auth.password') }}" wire:model="password" type="password" icon="o-key" />

        <x-slot:actions>
            @if (config('settings.registration_enabled'))
                <x-button label="{{ __('auth.create_account') }}" class="btn-ghost" link="/register" />
            @endif
            <x-button label="{{ __('auth.login') }}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
        </x-slot:actions>
    </x-form>
</div>
