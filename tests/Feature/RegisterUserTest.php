<?php

use App\Http\Controllers\AuthController;
use App\Models\User;

it('can register with correct credentials', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Mahmut Test",
        'email' => "mahmut@test.com",
        'password' => "12345678",
        'password_confirmation' => "12345678"
    ])->assertStatus(201);
});
it('cannot register with same credentials', function () {
    $user = User::Factory()->create();
    $this->post(action([AuthController::class, 'register']), [
        'name' => $user->name,
        'email' => $user->email,
        'password' => $user->password,
        'password_confirmation' => $user->password
    ])->assertStatus(422);
});
it('cannot register with wrong credentials', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Wrong Credentials",
        'email' => "blabla@wrong.net",
        'password' => "12345",
        'password_confirmation' => '1234'
    ])->assertStatus(422);
});
it('cannot register with missing credentials', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => 'Missing Credentials',
    ])->assertStatus(422);
});

