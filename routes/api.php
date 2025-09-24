<?php

use App\Http\Controllers\ContactUsController;
use Illuminate\Support\Facades\Route;


Route::post('/contacts', [ContactUsController::class, 'store']); // Create a contact
Route::get('/contacts', [ContactUsController::class, 'index']); // Get all contacts
Route::get('/contacts/{id}', [ContactUsController::class, 'show']); // Get a single contact
Route::put('/contacts/{id}', [ContactUsController::class, 'update']); // Update a contact
Route::delete('/contacts/{id}', [ContactUsController::class, 'destroy']); // Delete a contact