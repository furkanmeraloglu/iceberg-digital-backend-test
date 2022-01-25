<?php

namespace App\Repository\Repositories;


use App\Models\Appointment;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Support\DistanceMatrixApi;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JustSteveKing\LaravelPostcodes\Facades\Postcode;
use DateTime;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     * @param null $filter
     * @return Collection
     */
    public function getAll($filter = null): Collection
    {
        if ($filter === 'ASC' || $filter === 'asc')
        {
            return Appointment::orderBy('created_at', 'ASC')->get();
        }
        return Appointment::orderBy('created_at', 'DESC')->get();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Appointment::create($attributes);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return Model
     */
    public function update($id, array $attributes): Model
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($attributes);
        return $appointment;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return Appointment::findOrFail($id)->delete();
    }

    /**
     * @param $id
     * @return int
     */
    public function getContactId($id) : int
    {
        return Appointment::findOrFail($id)->contact_id;
    }

    /**
     * @param $postcode
     * @return mixed
     */
    public function getDestinationLatitude($postcode)
    {
        return Postcode::getPostcode($postcode)->latitude;
    }

    /**
     * @param $postcode
     * @return mixed
     */
    public function getDestinationLongitude($postcode)
    {
        return Postcode::getPostcode($postcode)->longitude;
    }

    /**
     * @param $postcode
     * @return string
     */
    public function calculateDistance($postcode) : string
    {
        $destLat = $this->getDestinationLatitude($postcode);
        $destLon = $this->getDestinationLongitude($postcode);
        $response = DistanceMatrixApi::getDistanceAndDuration($destLat, $destLon);
        return $response->original['distanceText'];
    }

    /**
     * @throws Exception
     */
    public function calculateDepartureTime($planned_at, $postcode) : Carbon
    {
        return (new Carbon(new DateTime($planned_at)))->subSeconds($this->getDuration($postcode));
    }

    /**
     * @throws Exception
     */
    public function calculateArrivalTime($planned_at, $postcode) : Carbon
    {
        $seconds = $this->getDuration($postcode) + 3600; // Adding default value of appointment duration to travel duration.
        return (new Carbon(new DateTime($planned_at)))->addSeconds($seconds);
    }

    /**
     * @param $postcode
     * @return mixed
     */
    private function getDuration($postcode)
    {
        $destLat = $this->getDestinationLatitude($postcode);
        $destLon = $this->getDestinationLongitude($postcode);
        $response = DistanceMatrixApi::getDistanceAndDuration($destLat, $destLon);
        return $response->original['duration'];
    }
}
