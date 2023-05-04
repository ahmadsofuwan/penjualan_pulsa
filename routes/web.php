<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('layout.master');
// });

Route::get('/', [App\Http\Controllers\Customer::class, 'index'])->name('home');
Route::get('export/', [App\Http\Controllers\Export::class, 'index'])->name('export');

Route::prefix('customers')->group(function () {
    Route::post('add/', [App\Http\Controllers\Customer::class, 'add'])->name('customers.add');
    Route::get('delete/{id}', [App\Http\Controllers\Customer::class, 'delete'])->name('customers.delete');
    Route::post('edit/', [App\Http\Controllers\Customer::class, 'edit'])->name('customers.edit');
});
Route::prefix('transaction')->group(function () {
    Route::get('/', [App\Http\Controllers\Transaction::class, 'index'])->name('transaction');
    Route::post('add/', [App\Http\Controllers\Transaction::class, 'add'])->name('transaction.add');
    Route::get('delete/{id}', [App\Http\Controllers\Transaction::class, 'delete'])->name('transaction.delete');
    Route::post('edit/', [App\Http\Controllers\Transaction::class, 'edit'])->name('transaction.edit');
});
