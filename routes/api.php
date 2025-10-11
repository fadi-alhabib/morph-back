<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerformerController;
use Illuminate\Support\Facades\Route;

Route::post("/login", [AuthController::class, "login"]);

// Contact Us routes
Route::post('/contacts', [ContactUsController::class, 'store']); // Create a contact
Route::get('/contacts', [ContactUsController::class, 'index']); // Get all contacts
Route::get('/contacts/{id}', [ContactUsController::class, 'show']); // Get a single contact
Route::put('/contacts/{id}', [ContactUsController::class, 'update']); // Update a contact
Route::delete('/contacts/{id}', [ContactUsController::class, 'destroy']); // Delete a contact

// Home routes
Route::get('/home', [HomeController::class, 'show']); // Get home data
Route::put('/home', [HomeController::class, 'update']); // Update home data

// Performer routes
Route::apiResource('performers', PerformerController::class);
