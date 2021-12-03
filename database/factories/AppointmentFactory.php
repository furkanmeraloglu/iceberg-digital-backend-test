<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'postcode' => strtoupper($this->faker->bothify('??##??')),
            'date' => $this->faker->dateTime('now', null),
            'duration' => 60,
            'departure_time' => $this->faker->time('H:i'),
            'arrival_time' => $this->faker->time('H:i'),
        ];
    }
}
