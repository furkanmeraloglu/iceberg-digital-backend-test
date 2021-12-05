<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(5)->create();

        $contact1 = new Contact();
        $contact1->name = 'Büşra Yurt';
        $contact1->email = 'billgates@mail.com';
        $contact1->phone = +905555555555;
        $contact1->save();
        $appointment1 = new Appointment();
        $appointment1->user_id = User::inRandomOrder()->first()->id;
        $appointment1->contact_id = Contact::find(1)->id;
        $appointment1->postcode = 'M320JG';
        $appointment1->date = Carbon::now()->addWeekday(2);
        $appointment1->save();

        $contact2 = new Contact();
        $contact2->name = 'Arda Yurt';
        $contact2->email = 'jonathanreinink@mail.com';
        $contact2->phone = +905555555554;
        $contact2->save();
        $appointment2 = new Appointment();
        $appointment2->user_id = User::inRandomOrder()->first()->id;
        $appointment2->contact_id = Contact::find(2)->id;
        $appointment2->postcode = 'NE301DP';
        $appointment2->date = Carbon::now()->addWeekday(4);
        $appointment2->save();

        $contact3 = new Contact();
        $contact3->name = 'George Otwell';
        $contact3->email = 'georgeotwell@mail.com';
        $contact3->phone = +905555555553;
        $contact3->save();
        $appointment13 = new Appointment();
        $appointment13->user_id = User::inRandomOrder()->first()->id;
        $appointment13->contact_id = Contact::find(3)->id;
        $appointment13->postcode = 'OX495NU';
        $appointment13->date = Carbon::now()->addWeekday(6);
        $appointment13->save();
    }
}
