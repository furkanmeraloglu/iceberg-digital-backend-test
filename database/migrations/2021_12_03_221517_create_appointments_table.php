<?php

use App\Models\Contact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Contact::class);
            $table->string('postcode');
            $table->string('home_postcode')->default('cm27pj');
            $table->text('distance')->nullable();
            $table->dateTime('planned_at');
            $table->double('duration')->default(60); // The default value for the appointment duration is 60 minutes
            $table->dateTime('should_depart_at')->nullable();
            $table->dateTime('should_arrive_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
}
