<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

new
#[Layout('layouts.empty')]
#[Title('Регистрация нового пользователя')]
class extends Component {

    #[Rule('required')]
    public string $name = '';

    #[Rule('required|email|unique:users')]
    public string $email = '';

    #[Rule('required|confirmed|min:8')]
    public string $password = '';

    #[Rule('required')]
    public string $password_confirmation = '';

    public function mount()
    {
        // It is logged in
        if (auth()->user()) {
            return redirect('/');
        }
    }

    public function register()
    {
        $data = $this->validate();

        $data['avatar'] = '/empty-user.jpg';
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        auth()->login($user);

        session()->regenerate();

        return redirect(route('home'));
    }
}
?>

<div class="md:w-96 mx-auto mt-20">
    <div class="mb-10">
        <x-app-brand />
    </div>

    <x-form wire:submit="register">
        <x-input placeholder="{{ __('auth.username') }}" wire:model="name" icon="o-user" />
        <x-input placeholder="{{ __('auth.email') }}" wire:model="email" icon="o-envelope" />
        <x-input placeholder="{{ __('auth.password') }}" wire:model="password" type="password" icon="o-key" />
        <x-input placeholder="{{ __('dashboard.confirm_password') }}" wire:model="password_confirmation" type="password" icon="o-key" />

        <x-slot:actions>
            <x-button label="{{ __('auth.registred') }}" class="btn-ghost" link="{{ route('login') }}" />
            <x-button label="{{ __('auth.create_account') }}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="register" />
        </x-slot:actions>
    </x-form>
</div>
