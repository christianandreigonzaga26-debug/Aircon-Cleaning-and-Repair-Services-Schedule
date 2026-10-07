<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Bookings fetched successfully.',
            'data' => Schedule::orderBy('schedule_date')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->bookingRules(),
            $this->validationMessages()
        );

        $schedule = Schedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking saved successfully!',
            'data' => $schedule,
        ], 201);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate(
            $this->bookingRules(),
            $this->validationMessages()
        );

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully!',
            'data' => $schedule->fresh(),
        ]);
    }

    protected function bookingRules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'min:2', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+()\-\s]{7,30}$/'],
            'service_type' => ['required', 'string', 'max:255'],
            'schedule_date' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    protected function validationMessages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.min' => 'Customer name must be at least 2 characters long.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone number must be a valid contact number.',
            'service_type.required' => 'Please choose a service type.',
            'schedule_date.required' => 'Please select a preferred date and time.',
            'schedule_date.date' => 'Please enter a valid date and time.',
            'schedule_date.after_or_equal' => 'Please choose a date and time that is today or later.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
        ];
    }
}