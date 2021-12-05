<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Contact;
use App\Repository\Interfaces\AppointmentRepositoryInterface;
use App\Repository\Interfaces\ContactRepositoryInterface;
use App\Support\PostcodeApi;
use Illuminate\Http\JsonResponse;

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
     */
    public function update(UpdateAppointmentRequest $request, $id): JsonResponse
    {
        $contact_id = $this->appointmentRepository->getContactId($id);
        $contact = $this->contactRepository->update($contact_id, $request->validated());
        $appointment = $this->appointmentRepository->update($id, array_merge(
            ['user_id' => auth()->user()->id],
            ['contact_id' => $contact->id],
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
}
