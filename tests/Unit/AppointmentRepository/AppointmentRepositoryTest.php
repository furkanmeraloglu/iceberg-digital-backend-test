<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Models\Appointment;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Carbon;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
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
});

test('user can get index of all appointments', function () {
    $this->get(action([AppointmentController::class, 'index']))
        ->assertJsonStructure([
            'appointments'
        ])
        ->assertStatus(200);
});

test('user can create an appointment', function () {
    $this->post(action([AppointmentController::class, 'store']), [
        'postcode' => 'SW1P3JA',
        'planned_at' => new Carbon('2021-12-06 15:30'),
        'name' => 'Furkan Meraloglu',
        'email' => 'furkanmeraloglu@hotmail.com',
        'phone' => '05555555555',
    ])->assertJsonStructure([
        'message',
        'appointment'
    ])->assertStatus(201);

    assertDatabaseHas('appointments', [
        'postcode' => 'sw1p3ja'
    ]);
});

test('user can update an appointment', function () {
    Contact::factory()->create();
    Appointment::factory()->create();
    $this->put('api/appointments/1', [
        'postcode' => 'SW1H0NN',
        'planned_at' => new Carbon('2021-12-06 15:50'),
        'name' => 'Furkan Meraloglu',
        'email' => 'furkanmeraloglu@hotmail.com',
        'phone' => '05555555555',
    ])->assertJsonStructure([
        'message',
        'appointment'
    ])->assertStatus(200);

    assertDatabaseHas('appointments', [
        'postcode' => strtolower('SW1H0NN')
    ]);
});

test('user can delete an appointment', function () {
    Contact::factory()->create();
    Appointment::factory()->create();
    $this->delete('api/appointments/1')
        ->assertJsonStructure([
            'message'
    ])->assertStatus(202);
});
