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