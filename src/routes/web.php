<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('docs', [DocumentController::class, 'index'])->name('docs.index');
Route::get('docs/{document}/{version?}', [DocumentController::class, 'show'])->name('docs.show');


Route::get('change-locale/{locale}', function ($locale) {

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('locale.switch');
