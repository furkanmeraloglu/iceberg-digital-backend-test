<?php

namespace App\Repository\Repositories;


use App\Models\Appointment;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
        return $appointment->update($attributes);
    }

    public function delete($id): bool
    {
        return Appointment::findOrFail($id)->delete();
    }
}
