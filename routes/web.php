<?php

Route::get('/', function () {
    return view('welcome');
});

Route::livewire('/login', 'pages::login')->name('login');
Route::livewire('/register', 'pages::register');
Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware('auth')->prefix("/home")->group(function () {
    Route::livewire('/', 'pages::home')->name('home');
    Route::livewire('/profile', 'pages::users.profile')->name('user.profile');

    //Route::livewire('/', 'pages::index');
    //Route::livewire('/users', 'pages::users.index');
    //Route::livewire('/users/create', 'pages::users.create');
    //Route::livewire('/users/{user}/edit', 'pages::users.edit');
    // ... more
});
