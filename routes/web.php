<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Frontend\Auth\Login;
use App\Livewire\Frontend\Auth\Register;
use App\Livewire\Frontend\Home;
use App\Livewire\Frontend\Trainings\TrainingList;
use App\Livewire\Frontend\Trainings\TrainingRegistration;
use App\Livewire\Frontend\Trainings\TrainingDetail;
use App\Livewire\Frontend\Facilities\FacilityList;
use App\Livewire\Frontend\Facilities\FacilityBooking;
use App\Livewire\Frontend\Facilities\FacilityDetail;
use App\Livewire\Frontend\Customer\Dashboard;

Route::get('/', Home::class)->name('home');

Route::get('/pelatihan', TrainingList::class)->name('training.list');
Route::get('/pelatihan/{training}', TrainingDetail::class)->name('training.detail');
Route::get('/pelatihan/{training}/daftar', TrainingRegistration::class)->name('training.registration');

Route::get('/fasilitas', FacilityList::class)->name('facility.list');
Route::get('/fasilitas/{facility}', FacilityDetail::class)->name('facility.detail');
Route::get('/fasilitas/{facility}/pesan', FacilityBooking::class)->name('facility.booking');

Route::middleware('guest:customer')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::guard('customer')->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});
