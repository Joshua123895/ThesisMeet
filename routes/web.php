<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LecturerAuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Consult\LecturerConsultController;
use App\Http\Controllers\Consult\StudentConsultController;
use App\Http\Controllers\Find\LecturerFindController;
use App\Http\Controllers\Find\StudentFindController;
use App\Http\Controllers\Profile\StudentProfileController;
use App\Http\Controllers\Profile\LecturerProfileController;
use App\Http\Controllers\Thesis\LecturerThesisController;
use App\Http\Controllers\Thesis\StudentThesisController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::redirect('/', '/login');

Route::get('/test', function () {
    return view('auth.reset-password');
});

Route::post('/locale/toggle', function () {
    $current = Session::get('locale', config('app.locale'));

    $next = $current === 'id' ? 'en' : 'id';

    App::setLocale($next);
    Session::put('locale', $next);

    return back();
})->name('locale.toggle');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register/student', [StudentAuthController::class, 'register']);
Route::post('/register/lecturer', [LecturerAuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

Route::middleware(['role.auth'])->group(function () {
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [AuthController::class, 'verifySend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::middleware(['role.auth:student', 'verified'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
    Route::get('/home', [StudentProfileController::class, 'home'])->name('home');
    Route::get('/profile', [StudentProfileController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    Route::get('/about-us', [StudentProfileController::class, 'aboutUs'])->name('about-us');
    Route::get('/consult/ongoing', [StudentConsultController::class, 'ongoing'])->name('consult.ongoing');
    Route::get('/consult/history', [StudentConsultController::class, 'history'])->name('consult.history');
    Route::get('/consult/history/delete/{appointment}', [StudentConsultController::class, 'deleteHistory'])->name('consult.history.delete');
    Route::get('/consult/history/clear', [StudentConsultController::class, 'clearHistory'])->name('consult.history.clear');
    Route::get('/consult/paper/{appointment}', [StudentConsultController::class, 'paper'])->name('consult.paper');
    Route::get('/consult/notes/{appointment}', [StudentConsultController::class, 'notes'])->name('consult.notes');
    Route::get('/consult/create', [StudentConsultController::class, 'create'])->name('consult.create');
    Route::put('/consult/create', [StudentConsultController::class, 'store'])->name('consult.store');
    Route::get('/find/lecturer', [StudentFindController::class, 'listLecturer'])->name('find.lecturer');
    Route::get('/find/lecturer/search', [StudentFindController::class, 'findLecturer'])->name('find.lecturer.search');
    Route::get('/find/schedule', [StudentFindController::class, 'lecturerCalendar'])->name('find.schedule');
    Route::get('/find/schedule/event', [StudentFindController::class, 'lecturerScheduleEvents'])->name('find.schedule.event');
    Route::get('/thesis', [StudentThesisController::class, 'index'])->name('thesis.show');
    Route::get('/thesis/accept/{thesis}', [StudentThesisController::class, 'accept'])->name('thesis.accept');
    Route::get('/thesis/reject/{thesis}', [StudentThesisController::class, 'reject'])->name('thesis.reject');
    Route::get('/thesis/paper/{thesis}', [StudentThesisController::class, 'paper'])->name('thesis.paper');
    Route::get('/thesis/paper/{thesis}/download', [StudentThesisController::class, 'download'])->name('thesis.paper.download');
    Route::get('/thesis/create', [StudentThesisController::class, 'create'])->name('thesis.create');
    Route::get('/thesis/student/search', [StudentThesisController::class, 'findStudent'])->name('thesis.student.search');
    Route::get('/thesis/lecturer/search', [StudentThesisController::class, 'findLecturer'])->name('thesis.lecturer.search');
    Route::post('/thesis', [StudentThesisController::class, 'store'])->name('thesis.store');
});

Route::middleware(['role.auth:lecturer', 'verified'])
    ->prefix('lecturer')
    ->name('lecturer.')
    ->group(function () {
    Route::get('/home', [LecturerProfileController::class, 'home'])->name('home');
    Route::get('/profile', [LecturerProfileController::class, 'profile'])->name('profile.show');
    Route::get('/profile/edit', [LecturerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [LecturerProfileController::class, 'update'])->name('profile.update');
    Route::get('/about-us', [LecturerProfileController::class, 'aboutUs'])->name('about-us');
    Route::get('/consult/review', [LecturerConsultController::class, 'review'])->name('consult.review');
    Route::put('/consult/review/accept/{appointment}', [LecturerConsultController::class, 'accept'])->name('consult.review.accept');
    Route::put('/consult/review/reject/{appointment}', [LecturerConsultController::class, 'reject'])->name('consult.review.reject');
    Route::get('/consult/ongoing', [LecturerConsultController::class, 'ongoing'])->name('consult.ongoing');
    Route::get('/consult/notes/{appointment}', [LecturerConsultController::class, 'view'])->name('consult.notes');
    Route::get('/consult/notes/create/{appointment}', [LecturerConsultController::class, 'note'])->name('consult.notes.create');
    Route::put('/consult/notes/create/{appointment}/update', [LecturerConsultController::class, 'updateNotes'])->name('consult.notes.update');
    Route::put('/consult/ongoing/reject/{appointment}', [LecturerConsultController::class, 'reject'])->name('consult.ongoing.reject');
    Route::get('/consult/history', [LecturerConsultController::class, 'history'])->name('consult.history');
    Route::get('/consult/delete/{appointment}', [LecturerConsultController::class, 'delete'])->name('consult.delete');
    Route::get('/consult/clear', [LecturerConsultController::class, 'clear'])->name('consult.clear');
    Route::get('/find/schedule', [LecturerFindController::class, 'calendar'])->name('find.schedule');
    Route::get('/find/schedule/event', [LecturerFindController::class, 'scheduleEvents'])->name('find.schedule.event');
    Route::get('/find/student', [LecturerFindController::class, 'listStudent'])->name('find.student');
    Route::get('/find/student/search', [LecturerFindController::class, 'findStudent'])->name('find.student.search');
    Route::put('/office/set', [LecturerFindController::class, 'setOffice'])->name('office.set');
    Route::get('/thesis/show', [LecturerThesisController::class, 'index'])->name('thesis.show');
    Route::get('/thesis/accept/{thesis}', [LecturerThesisController::class, 'accept'])->name('thesis.accept');
    Route::get('/thesis/approve/{thesis}', [LecturerThesisController::class, 'approve'])->name('thesis.approve');
    Route::get('/thesis/reject/{thesis}', [LecturerThesisController::class, 'reject'])->name('thesis.reject');
    Route::get('/thesis/paper/{thesis}', [LecturerThesisController::class, 'paper'])->name('thesis.paper');
    Route::get('/thesis/paper/{thesis}/download', [LecturerThesisController::class, 'download'])->name('thesis.paper.download');
});

Route::get('/force-logout', [AuthController::class, 'logout']);

Route::fallback(function () {
    return view('error/404');
});