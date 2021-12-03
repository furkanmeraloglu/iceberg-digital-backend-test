<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(10)->create();
        Appointment::factory(10)->create();
        Contact::factory(10)->create();
        foreach (Appointment::all() as $appointment)
        {
            $appointment->contacts()->attach(
                Contact::inRandomOrder()->take(1)->pluck('id')
            );
        }
    }
}
