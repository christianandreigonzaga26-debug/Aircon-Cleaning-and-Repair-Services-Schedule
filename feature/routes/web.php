use App\Http\Controllers\ScheduleController;

Route::get('/schedules', [ScheduleController::class, 'index']);

Route::post('/schedules', [ScheduleController::class, 'store']);

Route::put('/schedules/{schedule}', [ScheduleController::class, 'update']);

Route::get('/schedules/{schedule}', [ScheduleController::class, 'show']);

Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy']);
Route::get('/schedules', [ScheduleController::class, 'index']);

Route::delete('/schedules/{schedule}', [
    ScheduleController::class,
    'destroy'
]);