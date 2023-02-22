<?php

use App\Http\Controllers\ProfileController;
use App\Models\Task;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::get('/projects', function () {
        return view('pages.projects');
    })->name('projects');

    Route::get('/tasks/all', function () {
        return view('pages.tasks');
    })->name('tasks.all');

    Route::get('/tasks/todo', function () {
        return view('pages.tasks', [
            'title' => 'To do',
            'type' => Task\Type::Todo,
        ]);
    })->name('tasks.todo');

    Route::get('/tasks/calendar', function () {
        return view('pages.tasks', [
            'title' => 'Calendar',
            'type' => Task\Type::Calendar,
        ]);
    })->name('tasks.calendar');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
