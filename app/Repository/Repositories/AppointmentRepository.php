<?php

namespace App\Repository\Repositories;


use App\Models\Appointment;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use JustSteveKing\LaravelPostcodes\Facades\Postcode;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function getAll($filter = null): Collection
    {
        if ($filter === 'ASC')
        {
            return Appointment::orderBy('created_at', 'ASC')->get();
        }
        return Appointment::orderBy('created_at', 'DESC')->get();
    }
    public function create(array $attributes): Model
    {
        return Appointment::create($attributes);
    }
    public function update($id, array $attributes): Model
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($attributes);
        return $appointment;
    }
    public function delete($id): bool
    {
        return Appointment::findOrFail($id)->delete();
    }
    public function getContactId($id) : int
    {
        return Appointment::findOrFail($id)->contact_id;
    }
    public function validateDestinationPostcode($postcode)
    {
        return Postcode::validate($postcode);
    }
    public function getDestinationLatitude($postcode)
    {
        return Postcode::getPostcode($this->validateDestinationPostcode($postcode))->latitude;
    }
    public function getDestinationLongitude($postcode)
    {
        return Postcode::getPostcode($this->validateDestinationPostcode($postcode))->longitude;
    }
}
