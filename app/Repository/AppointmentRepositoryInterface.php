<?php

namespace App\Repository;
use Illuminate\Database\Eloquent\Model;

interface AppointmentRepositoryInterface
{
    public function getAllAppointments();
    public function getAppointmentsByDate($appointmentId);
    public function createAppointment(array $appointmentDetails);
    public function updateAppointment($appointmentId, array $appointmentDetails);
    public function deleteAppointment($appointmentId);
}
