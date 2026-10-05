public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:30'],
        'service_type' => ['required', 'string'],
        'schedule_date' => ['required', 'date'],
        'notes' => ['nullable', 'string'],
    ]);

    $schedule = Schedule::create($validated);

    return response()->json([
        'data' => $schedule,
    ], 201);
}

public function show($id)
{
    $schedule = \App\Models\Schedule::find($id);

    if (!$schedule) {
        return response()->view(
            'schedules.not-found',
            [],
            404
        );
    }

    return view('schedules.show', [
        'schedule' => $schedule
    ]);
}

public function destroy($id)
{
    $schedule = \App\Models\Schedule::find($id);

    if (!$schedule) {
        return response()->json([
            'message' => 'Booking not found.'
        ], 404);
    }

    $schedule->delete();

    return response()->json([
        'message' => 'Booking deleted successfully.'
    ]);
}

public function destroy($id)
{
    $schedule = \App\Models\Schedule::findOrFail($id);

    $schedule->delete();

    return response()->json([
        'message' => 'Booking deleted successfully.'
    ]);
}