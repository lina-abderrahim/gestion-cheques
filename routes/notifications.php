<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::middleware(['auth'])->group(function()
{
    Route::get('/Notifications',[NotificationController::class,'index'])->name('notifications.index');
    Route::post('/Notifications/{notification}/mark-read',[NotificationController::class,'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/Notifications/{notification}',[NotificationController::class,'destroy'])->name('notifications.destroy');
}
);
