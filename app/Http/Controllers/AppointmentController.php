<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Repository\Interfaces\ContactRepositoryInterface;
use App\Support\DistanceMatrixApi;
use App\Support\PostcodeApi;
use App\Support\GoogleDistanceMatrixApi;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Ramsey\Uuid\Type\Time;

class AppointmentController extends Controller
{
    protected $appointmentRepository;
    protected $contactRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository, ContactRepositoryInterface $contactRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $filter
     * @return JsonResponse
     */
    public function index($filter = null): JsonResponse
    {
        $appointments = $this->appointmentRepository->getAll($filter = null);
        return response()->json([
            'appointments' => $appointments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param StoreAppointmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreAppointmentRequest $request): JsonResponse
    {
        $contact = $this->contactRepository->create($request->validated());
        $appointment = $this->appointmentRepository->create(array_merge(
            ['contact_id' => $contact->id],
            ['user_id' => auth()->user()->id],
            ['distance' => $this->calculateDistance($request->postcode)],
            ['should_depart_at' => $this->calculateDepartureTime($request->planned_at, $request->postcode)],
            ['should_arrive_at' => $this->calculateArrivalTime($request->planned_at, $request->postcode)],
            $request->validated()
        ));
        return response()->json([
            'message' => 'Appointment successfully created',
            'appointment' => $appointment
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAppointmentRequest $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function update(UpdateAppointmentRequest $request, $id): JsonResponse
    {
        $contact_id = $this->appointmentRepository->getContactId($id);
        $contact = $this->contactRepository->update($contact_id, $request->validated());
        $appointment = $this->appointmentRepository->update($id, array_merge(
            ['contact_id' => $contact->id],
            ['user_id' => auth()->user()->id],
            ['distance' => $this->calculateDistance($request->postcode)],
            ['should_depart_at' => $this->calculateDepartureTime($request->planned_at, $request->postcode)],
            ['should_arrive_at' => $this->calculateArrivalTime($request->planned_at, $request->postcode)],
            $request->validated()
        ));
        return response()->json([
            'message' => 'Appointment successfully updated',
            'appointment' => $appointment
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $appointment = $this->appointmentRepository->delete($id);
        return response()->json([
            'message' => 'Appointment successfully deleted',
        ], 202);
    }

    private function calculateDistance($postcode) : string
    {
        $destLat = $this->appointmentRepository->getDestinationLatitude($postcode);
        $destLon = $this->appointmentRepository->getDestinationLongitude($postcode);
        $response = DistanceMatrixApi::getDistanceAndDuration($destLat, $destLon);
        return $response->original['distanceText'];
    }

    /**
     * @throws Exception
     */
    private function calculateDepartureTime($planned_at, $postcode) : Carbon
    {
        $time = new Carbon(new DateTime($planned_at));
        return $time->subSeconds($this->getDuration($postcode));
    }
    // 21:46 fixed
    // 20:08 Sub
    // 23:26 Add

    /**
     * @throws Exception
     */
    private function calculateArrivalTime($planned_at, $postcode) : Carbon
    {
        $seconds = $this->getDuration($postcode) + 3600; // Adding default value of appointment duration to travel duration.
        $time = new Carbon(new DateTime($planned_at));
        return $time->addSeconds($seconds);
    }
    private function getDuration($postcode)
    {
        $destLat = $this->appointmentRepository->getDestinationLatitude($postcode);
        $destLon = $this->appointmentRepository->getDestinationLongitude($postcode);
        $response = DistanceMatrixApi::getDistanceAndDuration($destLat, $destLon);
        return $response->original['duration'];
    }
}
