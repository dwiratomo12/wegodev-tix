<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});

Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {

    //rooms
    Route::get('/dashboard/rooms', [App\Http\Controllers\Dashboard\RoomController::class, 'index'])->name('dashboard.rooms');
    Route::get('/dashboard/rooms/create', [App\Http\Controllers\Dashboard\RoomController::class, 'create'])->name('dashboard.rooms.create');
    Route::post('/dashboard/rooms', [App\Http\Controllers\Dashboard\RoomController::class, 'store'])->name('dashboard.rooms.store');
    Route::get('/dashboard/rooms/{room}', [App\Http\Controllers\Dashboard\RoomController::class, 'edit'])->name('dashboard.rooms.edit');
    Route::put('/dashboard/rooms/{room}', [App\Http\Controllers\Dashboard\RoomController::class, 'update'])->name('dashboard.rooms.update');
    Route::delete('/dashboard/rooms/{room}', [App\Http\Controllers\Dashboard\RoomController::class, 'destroy'])->name('dashboard.rooms.delete');

    //Users
    Route::get('/dashboard/users', [App\Http\Controllers\Dashboard\UserController::class, 'index'])->name('dashboard.users');
    Route::get('/dashboard/users/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'edit'])->name('dashboard.users.edit');
    Route::put('/dashboard/users/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'update'])->name('dashboard.users.update');
    Route::delete('/dashboard/users/{id}', [App\Http\Controllers\Dashboard\UserController::class, 'destroy'])->name('dashboard.users.delete');

    //mahasiswa
    Route::get('/dashboard/mahasiswa', [App\Http\Controllers\Dashboard\MahasiswaController::class, 'index'])->name('dashboard.mahasiswa');
    Route::get('/dashboard/mahasiswa/create', [App\Http\Controllers\Dashboard\MahasiswaController::class, 'create'])->name('dashboard.mahasiswa.create');
    Route::post('/dashboard/mahasiswa', [App\Http\Controllers\Dashboard\MahasiswaController::class, 'store'])->name('dashboard.mahasiswa.store');
    Route::get('/dashboard/mahasiswa/{id}', [App\Http\Controllers\Dashboard\MahasiswaController::class, 'edit'])->name('dashboard.mahasiswa.edit');
    Route::put('/dashboard/mahasiswa/{id}', [App\Http\Controllers\Dashboard\MahasiswaController::class, 'update'])->name('dashboard.mahasiswa.update');
    Route::delete('/dashboard/mahasiswa/{id}', [App\Http\Controllers\Dashboard\MahasiswaController::class, 'destroy'])->name('dashboard.mahasiswa.delete');

    //transactions
    Route::get('/dashboard/transactions/{transaction}', [App\Http\Controllers\Dashboard\TransactionController::class, 'edit'])->name('dashboard.transactions.edit');
    Route::put('/dashboard/transactions/{transaction}', [App\Http\Controllers\Dashboard\TransactionController::class, 'update'])->name('dashboard.transactions.update');
    Route::delete('/dashboard/transactions/{transaction}', [App\Http\Controllers\Dashboard\TransactionController::class, 'destroy'])->name('dashboard.transactions.delete');

    //history
    Route::get('/dashboard/history', [App\Http\Controllers\Dashboard\HistoriAdminController::class, 'index'])->name('dashboard.histori.admin');
});

Route::group(['middleware' => ['auth', 'checkRole:admin,siswa,dosen']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    //transactions
    Route::get('/dashboard/transactions', [App\Http\Controllers\Dashboard\TransactionController::class, 'index'])->name('dashboard.transactions');
    Route::get('/dashboard/create', [App\Http\Controllers\Dashboard\TransactionController::class, 'create'])->name('dashboard.transactions.create');
    Route::post('/dashboard/transactions', [App\Http\Controllers\Dashboard\TransactionController::class, 'store'])->name('dashboard.transactions.store');
});