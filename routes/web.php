<?php

use App\Http\Controllers\LectureController;
use App\Http\Controllers\ProfileController;
use App\Models\Activity;
use App\Models\Lecture;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $modules = collect();
    $sectionModules = collect();

    if ($user) {
        $modules = $user->modules ?? collect();
        $section = $user->section;
        if ($section) {
            $sectionModules = $section->modules ?? collect();
        }
    }

    $modules = $modules->merge($sectionModules);

    $activities = $modules->flatMap(function ($module) {
        return $module->lectures->flatMap(function ($lecture) {
            return $lecture->activities ?? collect();
        });
    });

    return view('dashboard', [
        'user' => $user,
        'modules' => $modules,
        'activities' => $activities,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/modules', function() {
    $user = Auth::user();
    $modules = collect();
    $sectionModules = collect();
    $activities = collect();
    $sectionActivities = collect();

    if ($user) {
        $modules = $user->modules ?? collect();

        $section = $user->section;
        if ($section) {
            $sectionModules = $section->modules ?? collect();
        }

        $modules = $modules->merge($sectionModules);

        if ($user->lectures) {
            foreach ($user->lectures as $lecture) {
                $activities = $activities->merge($lecture->activities ?? collect());
            }
        }

        if ($section && $section->lectures) {
            foreach ($section->lectures as $lecture) {
                $sectionActivities = $sectionActivities->merge($lecture->activities ?? collect());
            }
        }

        $activities = $activities->merge($sectionActivities);
    }

    return view('homepage', [
        'modules' => $modules,
        'user' => $user,
        'activities' => $activities,
    ]);
})->name('modules');



Route::get('/modules/{module:id}', function(Module $module) {
    $user = Auth::user();

    // Retrieve lectures directly related to the module
    $moduleLectures = $module->lectures;

    // Initialize arrays to store locked and unlocked lectures
    $lockedLectures = [];
    $unlockedLectures = [];

    if ($user) {
        foreach ($moduleLectures as $lecture) {
            // Check if the lecture is unlocked for the user or their section
            $isUnlocked = $lecture->users()->where('user_id', $user->id)->exists() ||
                $lecture->sections()->where('section_id', $user->section->id)->exists();

            if ($isUnlocked) {
                $unlockedLectures[] = $lecture;
            } else {
                $lockedLectures[] = $lecture;
            }
        }
    } else {
        // If user is not authenticated, consider all module lectures as unlocked
        $unlockedLectures = $moduleLectures;
    }

    return view('module', [
        'lockedLectures' => $lockedLectures,
        'unlockedLectures' => $unlockedLectures,
        'module' => $module,
    ]);
})->name('module');



Route::get('/lecture/{lecture:id}', function(Lecture $lecture){
    $activities = $lecture->activities;
    $module = $lecture->module;
    $lectures = $module->lectures;

    return view('lecture', [
        'lecture' => $lecture,
        'activities' => $activities,
        'lectures' => $lectures,
        'user' => Auth::user(),
    ]);
})->name('module');

Route::get('/quiz/{activity:id}', function(\App\Models\Activity $activity){
    $questions = $activity->questions;


    return view('quiz', [
            'questions' => $questions,
            'activity' => $activity
        ]);
})->name('module');

Route::get('/fileSubmit/{activity:id}', function (\App\Models\Activity $activity) {


    return view('fileSubmit', [
        'activity' => $activity
    ]);
});

Route::get('/fillBlanks/{activity:id}', function(\App\Models\Activity $activity){
    $questions = $activity->questions;

    return view('fillBlanks', [
        'questions' => $questions,
        'activity' => $activity
    ]);
})->name('module');

Route::get('/activity/{activity:id}', function(\App\Models\Activity $activity){
    $questions = $activity->questions;
    $user = Auth::user();


    return view('activity', [
        'questions' => $questions,
        'activity' => $activity,
        'user' => $user,
    ]);
})->name('module');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/quiz/submit', [ActivityController::class, 'showScore'])->name('quiz.submit');
Route::post('/lecture/unlock', [LectureController::class, 'unlockLecture'])->name('lecture.unlock');
Route::post('/activity/attempt', [ActivityController::class, 'deductCoins'])->name('activity.attempt');
Route::post('/fileSubmit/submit', [ActivityController::class, 'submitFile'])->name('file.submit');

require __DIR__.'/auth.php';
