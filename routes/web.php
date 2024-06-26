<?php

use App\Http\Controllers\Admin\MasterUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionGroupController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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
   return redirect()->route('login');
})->name('index');

Auth::routes([
   'register' => false,
   'reset' => false,
   'confirm' => false,
]);

Route::prefix('admin')->middleware(['auth'])->group(function () {

   Route::prefix('app')->middleware(['auth'])->group(function () {
      Route::resource('role', RoleController::class);
      Route::resource('permission-group', PermissionGroupController::class);
      Route::resource('permission', PermissionController::class);

      Route::resource('master-user', MasterUserController::class);
      Route::controller(MasterUserController::class)->name('master-user.')->group(function () {
         Route::post('revoke-permission', 'revokePermission')->name('revoke.permission');
         Route::post('add-permission', 'addDirectPermission')->name('add.direct.permission');
         Route::put('active-status', 'setActiveStatus')->name('active-status');
         Route::post('password/reset', 'passwordReset')->name('password-reset');
         Route::post('force-login/{user_id}', 'forceLogin')->name('force-login');
      });
   });

   Route::get('settings/', [SettingsController::class, 'index'])->name('settings.index');
   Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');
   Route::put('settings/datatable', [SettingsController::class, 'datatableUpdate'])->name('settings.datatable');
   Route::post('settings/reset/{cache_key}', [SettingsController::class, 'reset'])->name('settings.reset');

   Route::get('/', [DashboardController::class, 'index'])->name('admin');
   Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
   Route::get('auditlog', [DashboardController::class, 'getAuditLog'])->name('audit-log');

   Route::controller(AuthController::class)->group(function () {
      Route::put('password-ubah', 'ubahPassword')->name('password.ubah');
   });
});
