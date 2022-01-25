<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Repository\Repositories\AppointmentRepository;

class AppointmentFactory extends Factory
{
    protected $postcodes = [
        'OX495NU',
        'M320JG',
        'NE301DP',
        'SW1H0NN',
        'SW1P3JA'
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'contact_id' => Contact::inRandomOrder()->first()->id,
            'postcode' => $this->postcodes[random_int(0,4)],
            'planned_at' => new Carbon('2021-12-06 15:30'),
        ];
    }
}
