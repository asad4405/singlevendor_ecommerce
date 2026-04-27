<?php

use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

// =========== api ============= //
Route::get('settings',[SettingsController::class,'settings']);
Route::get('contact-info',[SettingsController::class,'contact_info']);
