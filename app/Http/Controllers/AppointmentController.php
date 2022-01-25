<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Repository\Interfaces\ContactRepositoryInterface;
use App\Support\DistanceMatrixApi;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = $request->input('filter');
        $appointments = $this->appointmentRepository->getAll($query);
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
        return DB::transaction(function () use($request) {
            try {
                $contact = $this->contactRepository->create($request->validated());
                $appointment = $this->appointmentRepository->create(array_merge(
                    ['contact_id' => $contact->id],
                    ['user_id' => auth()->user()->id],
                    ['distance' => $this->appointmentRepository->calculateDistance($request->postcode)],
                    ['should_depart_at' => $this->appointmentRepository->calculateDepartureTime($request->planned_at, $request->postcode)],
                    ['should_arrive_at' => $this->appointmentRepository->calculateArrivalTime($request->planned_at, $request->postcode)],
                    $request->validated()
                ));
                return response()->json([
                    'message' => 'Appointment successfully created',
                    'appointment' => $appointment
                ], 201);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error occurred. Please try again.',
                    'error' => $th->getMessage(),
                ]);
            }
        });
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
        return DB::transaction(function () use($request, $id) {
            try {
                $contact_id = $this->appointmentRepository->getContactId($id);
                $contact = $this->contactRepository->update($contact_id, $request->validated());
                $appointment = $this->appointmentRepository->update($id, array_merge(
                    ['contact_id' => $contact->id],
                    ['user_id' => auth()->user()->id],
                    ['distance' => $this->appointmentRepository->calculateDistance($request->postcode)],
                    ['should_depart_at' => $this->appointmentRepository->calculateDepartureTime($request->planned_at, $request->postcode)],
                    ['should_arrive_at' => $this->appointmentRepository->calculateArrivalTime($request->planned_at, $request->postcode)],
                    $request->validated()
                ));
                return response()->json([
                    'message' => 'Appointment successfully updated',
                    'appointment' => $appointment
                ],200);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error occurred. Please try again.',
                    'error' => $th->getMessage(),
                ]);
            }
        });
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
}
