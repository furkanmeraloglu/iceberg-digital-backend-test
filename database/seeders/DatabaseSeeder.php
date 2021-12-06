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
        $contact1->name = 'Bill Gates';
        $contact1->email = 'billgates@mail.com';
        $contact1->phone = +905555555555;
        $contact1->save();
        $appointment1 = new Appointment();
        $appointment1->user_id = User::inRandomOrder()->first()->id;
        $appointment1->contact_id = Contact::find(1)->id;
        $appointment1->postcode = 'M320JG';
        $appointment1->planned_at = new Carbon('2021-12-06 15:30');
        $appointment1->save();

        $contact2 = new Contact();
        $contact2->name = 'Jonathan Reinink';
        $contact2->email = 'jonathanreinink@mail.com';
        $contact2->phone = +905555555554;
        $contact2->save();
        $appointment2 = new Appointment();
        $appointment2->user_id = User::inRandomOrder()->first()->id;
        $appointment2->contact_id = Contact::find(2)->id;
        $appointment2->postcode = 'NE301DP';
        $appointment2->planned_at = new Carbon('2021-12-11 15:30');
        $appointment2->save();

        $contact3 = new Contact();
        $contact3->name = 'George Otwell';
        $contact3->email = 'georgeotwell@mail.com';
        $contact3->phone = +905555555553;
        $contact3->save();
        $appointment3 = new Appointment();
        $appointment3->user_id = User::inRandomOrder()->first()->id;
        $appointment3->contact_id = Contact::find(3)->id;
        $appointment3->postcode = 'OX495NU';
        $appointment3->planned_at = new Carbon('2021-12-08 13:30');
        $appointment3->save();
    }
}
