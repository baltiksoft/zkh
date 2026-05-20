<?php

use Livewire\Livewire;
use App\Models\User;
use Illuminate\Session\Store;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\assertGuest;

beforeEach(function () {
    // Стартуем сессию через встроенный трейт
    $this->startSession();

    // Получаем экземпляр сессии
    $session = $this->app->make(Store::class);

    // Привязываем сессию к текущему объекту Request
    $this->app['request']->setLaravelSession($session);
});

it('Авторизация пользователя через компонент «Входа в систему»', function () {
    $user = User::factory()->create([
        'email' => 'testuser@test.ru', // компонент ожидает поле name
        'password' => bcrypt('password'),
    ]);

    $this->assertNotNull($this->app['request']->session());

    Livewire::test('pages::users.login')
        ->set('email', 'testuser@test.ru')
        ->set('password', 'password')
        ->call('login')
        ->assertRedirect(route('home'));

    assertAuthenticated();
});

it('Авторизация пользователя через компонент «Входа в систему» c неверными данными', function () {
    $user = User::factory()->create([
        'email' => 'testuser@ttt.ru',
        'password' => bcrypt('password'),
    ]);

    $this->assertNotNull($this->app['request']->session());

    Livewire::test('pages::users.login')
        ->set('email', 'testuser@ttt.ru')
        ->set('password', 'wrong-password')
        ->call('login')
        ->assertHasErrors(['email' => __('auth.failed')]);

    assertGuest();
});
