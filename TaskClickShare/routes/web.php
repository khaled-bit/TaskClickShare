<?php
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Route;
use App\Livewire\Orders;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/list-sheets', function () {
    $sheetsService = new GoogleSheetsService();
    $sheetsService->listSheets();
});
Route::get('/Orders', Orders::class);
