<?php

namespace App\Repository\Repositories;

use App\Repository\AppointmentRepositoryInterface;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     * @return Appointment[]|Collection
     */
    public function getAllAppointments()
    {
        return Appointment::all();
    }
    public function getAppointmentsByDate($appointmentId)
    {

    }
    public function createAppointment(array $appointmentDetails)
    {

    }
    public function updateAppointment($appointmentId, array $appointmentDetails)
    {

    }
    public function deleteAppointment($appointmentId)
    {

    }
}
