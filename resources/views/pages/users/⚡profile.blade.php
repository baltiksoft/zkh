<?php

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

new
#[Title('Профиль пользователя')]
class extends Component {
    use Toast;

    #[Rule('required')]
    public string $name;

    #[Rule('required|email')]
    public string $email;

    #[Rule('confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public User $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->fill($this->user);
    }

    public function save()
    {
        $data = $this->validate();

        $data['avatar'] = '/empty-user.jpg';
        //if ($this->password != '') {
        $data['password'] = Hash::make($data['password']);
        //}

        $this->user->update($data);

        $this->success('Профиль обновлён', redirectTo: route('home'));
    }
};
?>

<div>
    <x-header title="Профиль пользователя «{{ $user->name }}»" separator/>
    <x-form wire:submit="save">
        <x-input label="E-mail пользователя" icon="o-envelope" wire:model="email" readonly clearable/>
        <x-input label="Имя пользователя" icon="o-user" wire:model="name"  clearable/>
        <x-input placeholder="{{ __('auth.password') }}" wire:model="password" type="password" icon="o-key" />
        <x-input placeholder="{{ __('auth.password_confirm') }}" wire:model="password_confirmation" type="password" icon="o-key" />
        <x-slot:actions>
            <x-button label="Сохранить" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary"/>
            <x-button label="Отмена" link="{{ route('home') }}"/>
        </x-slot:actions>
    </x-form>
</div>
