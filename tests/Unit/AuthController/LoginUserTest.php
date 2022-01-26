<?php

use App\Http\Controllers\AuthController;
use App\Models\User;

test('registered user can login', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Mahmut Test",
        'email' => "mahmut@test.com",
        'password' => "12345678",
        'password_confirmation' => "12345678"
    ]);
    $this->post(action([AuthController::class, 'login']), [
        'email' => "mahmut@test.com",
        'password' => "12345678"
    ])->assertJsonStructure([
        'access_token',
        'token_type',
        'expires_in',
        'user'
    ])->assertStatus(200);
});

test('registered user cannot login with wrong credentials', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Mahmut Test",
        'email' => "mahmut@test.com",
        'password' => "12345678",
        'password_confirmation' => "12345678"
    ]);
    $this->post(action([AuthController::class, 'login']), [
        'email' => "mahmut@test.com",
        'password' => "123456789"
    ])->assertStatus(401);
});

test('logged in user can logout', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Mahmut Test",
        'email' => "mahmut@test.com",
        'password' => "12345678",
        'password_confirmation' => "12345678"
    ]);
    $this->post(action([AuthController::class, 'login']), [
        'email' => "mahmut@test.com",
        'password' => "12345678"
    ]);
    $this->post(action([AuthController::class, 'logout']))
        ->assertJsonStructure([
            'message'
        ])->assertStatus(200);
});

test('logged in user can get user-profile', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Mahmut Test",
        'email' => "mahmut@test.com",
        'password' => "12345678",
        'password_confirmation' => "12345678"
    ]);
    $this->post(action([AuthController::class, 'login']), [
        'email' => "mahmut@test.com",
        'password' => "12345678"
    ]);
    $this->get(action([AuthController::class, 'userProfile']))
        ->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'is_admin',
            'created_at',
            'updated_at'
        ])->assertStatus(200);
});

test('logged in user can refresh token', function () {
    $this->post(action([AuthController::class, 'register']), [
        'name' => "Mahmut Test",
        'email' => "mahmut@test.com",
        'password' => "12345678",
        'password_confirmation' => "12345678"
    ]);
    $this->post(action([AuthController::class, 'login']), [
        'email' => "mahmut@test.com",
        'password' => "12345678"
    ]);
    $this->get(action([AuthController::class, 'refresh']))
        ->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user'
        ])->assertStatus(200);
});
