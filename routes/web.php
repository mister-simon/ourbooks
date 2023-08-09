<?php

use App\Models\Shelf;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/shelf/{shelf}', function (Shelf $shelf) {
    return view('pages.[Shelf].index', ['shelf' => $shelf]);
})
    ->middleware('signed')
    ->name('shelf');
