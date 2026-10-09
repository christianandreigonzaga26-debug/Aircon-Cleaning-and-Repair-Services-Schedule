use App\Http\Controllers\ScheduleController;

Route::get('/schedules', [ScheduleController::class, 'index']);
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::put('/schedules/{schedule}', [ScheduleController::class, 'update']);