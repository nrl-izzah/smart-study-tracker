<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\StudyTask;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $userId = Auth::id();

    $stats = [
        'total' => StudyTask::where('user_id',$userId)->count(),
        'completed' => StudyTask::where('user_id',$userId)
                        ->where('status','completed')->count(),
        'pending' => StudyTask::where('user_id',$userId)
                        ->where('status','pending')->count(),
    ];

    $upcomingTasks = StudyTask::where('user_id',$userId)
        ->orderBy('deadline','asc')
        ->limit(5)
        ->get();

    return view('dashboard', compact('stats','upcomingTasks'));

})->middleware(['auth','verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function(){

    // TASKS
    Route::get('/tasks',[TaskController::class,'index'])->name('tasks.index');
    Route::post('/tasks',[TaskController::class,'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit',[TaskController::class,'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}',[TaskController::class,'update'])->name('tasks.update');
    Route::delete('/tasks/{task}',[TaskController::class,'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/complete',[TaskController::class,'complete'])->name('tasks.complete');

    // PROFILE
    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');



});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','admin'])->group(function(){

    Route::get('/admin', function(){
        return view('admin.dashboard');
    });

    Route::delete('/admin/delete-task/{id}', function($id){
        StudyTask::where('id',$id)->delete();
        return back();
    });

    Route::post('/admin/toggle-user/{id}', function($id){
        $user = \App\Models\User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();
        return back();
    });



});

require __DIR__.'/auth.php';
