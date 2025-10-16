<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MedicalFacilityController;
use App\Http\Controllers\Admin\MedicalServiceController;
use App\Http\Controllers\Admin\WorkingPeriodController;
use App\Http\Controllers\Admin\MedicalFacilityCategoryController;
use App\Http\Controllers\Admin\FacilityOwnershipController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\GovernorateController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ContentBlockController;
use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Support\RoutePermissions;


Route::middleware(['auth'])->group(function () {
    Route::resource('medical-facilities', MedicalFacilityController::class)
        ->names('admin.medical-facilities')
        ->middleware(RoutePermissions::resource('medical-facilities'));

    Route::resource('medical-services', MedicalServiceController::class)
        ->names('admin.medical-services')
        ->middleware(RoutePermissions::resource('medical-services'));

    Route::resource('working-periods', WorkingPeriodController::class)
        ->names('admin.working-periods')
        ->middleware(RoutePermissions::resource('working-periods'));

    Route::resource('medical-facility-categories', MedicalFacilityCategoryController::class)
        ->names('admin.medical-facility-categories')
        ->middleware(RoutePermissions::resource('medical-facility-categories'));

    Route::resource('facility-ownerships', FacilityOwnershipController::class)
        ->names('admin.facility-ownerships')
        ->middleware(RoutePermissions::resource('facility-ownerships'));

    Route::resource('areas', AreaController::class)
        ->names('admin.areas')
        ->middleware(RoutePermissions::resource('areas'));

    Route::resource('districts', DistrictController::class)
        ->names('admin.districts')
        ->middleware(RoutePermissions::resource('districts'));

    Route::resource('governorates', GovernorateController::class)
        ->names('admin.governorates')
        ->middleware(RoutePermissions::resource('governorates'));

    Route::resource('specialties', SpecialtyController::class)
        ->names('admin.specialties')
        ->middleware(RoutePermissions::resource('specialties'));

    Route::resource('advertisements', AdvertisementController::class)
        ->names('admin.advertisements')
        ->middleware(RoutePermissions::resource('advertisements'));

    Route::resource('content-blocks', ContentBlockController::class)
        ->names('admin.content-blocks')
        ->middleware(RoutePermissions::resource('content-blocks'));

    Route::resource('conversations', ConversationController::class)
        ->names('admin.conversations')
        ->middleware(RoutePermissions::resource('conversations'));

    Route::resource('users', UserController::class)
        ->names('admin.users');

    Route::patch('users/{id}/activate', [UserController::class, 'activate'])
        ->name('admin.users.activate')
        ->middleware(RoutePermissions::can('users.edit'));

    Route::patch('users/{id}/deactivate', [UserController::class, 'deactivate'])
        ->name('admin.users.deactivate')
        ->middleware(RoutePermissions::can('users.edit'));

    Route::resource('roles', RoleController::class)
        ->names('admin.roles');

    Route::get('permissions', [PermissionController::class, 'index'])
        ->name('admin.permissions.index');

    Route::get('/profile', fn () => Inertia('Others/UserProfile'))
        ->middleware(RoutePermissions::can('profile.view'));

    Route::get('/', fn () => Inertia('Dashboard'))
        ->name('dashboard')
        ->middleware(RoutePermissions::can('dashboard.view'));
});

// روابط مصادقة لوحة التحكم (بدون حماية)
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');