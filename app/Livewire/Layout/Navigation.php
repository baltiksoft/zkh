<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class Navigation extends Component
{
    public array $menuItems = [];


    public function mount()
    {
        // Загружаем пункты меню, например, из БД или конфига
        $this->menuItems = [
            ['title' => __('dashboard.dashboard'), 'icon' => 'o-home', 'link' => route('home')],

           // ['title' => 'Пользователи', 'icon' => 'o-users', 'link' => route('users.index'), 'permission' => 'manage-users'],
        ];
    }

    public function render()
    {
        return view('livewire.layout.navigation');
    }
}
