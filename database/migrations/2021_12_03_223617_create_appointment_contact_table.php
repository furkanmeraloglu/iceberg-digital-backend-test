<?php

use App\Models\Appointment;
use App\Models\Contact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_contact', function (Blueprint $table) {
            $table->foreignIdFor(Appointment::class);
            $table->foreignIdFor(Contact::class);
            $table->unique(['appointment_id', 'contact_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_contact');
    }
}
