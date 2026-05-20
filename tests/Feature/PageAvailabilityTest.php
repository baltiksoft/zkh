<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('главная страница доступна', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('страница контактов содержит текст «Вход в систему»', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('Вход в систему');
});

test('Авторизованный пользователь видит страницу «Личный кабинет»', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('home'))
        ->assertOk()
        ->assertSee($user->name);
});

test('Гость не может просматривать страницу «Личный кабинет»', function () {
    get(route('home'))->assertRedirect(route('login'));
});

test('Авторизованный пользователь видит страницу «Спортсмены»', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('persons.index'))
        ->assertOk()
        ->assertSee(__('dashboard.persons.index'));
});

test('Авторизованный пользователь видит страницу «Создать Спортсмена»', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('persons.create'))
        ->assertOk()
        ->assertSee(__('dashboard.persons.index'));
});

