use App\Http\Controllers\ScheduleController;

Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::get('/schedules/{schedule}', [ScheduleController::class, 'show']);
Route::put('/schedules/{schedule}', [ScheduleController::class, 'update']);
Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy']);