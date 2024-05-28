<?php

use App\Http\Controllers\Admin\SampleCrudController;
use App\Http\Controllers\Admin\TinyEditorController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Klinik\Dashboard\DashboarddController;


use App\Http\Controllers\MyApp\Report\LaporanController as ReportLaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware(['auth'])->group(function () {
   Route::get('beranda', [BerandaController::class, 'index'])->name('beranda.index');
   Route::controller(UserController::class)->group(function () {
      Route::put('user/profile/{user_id}', 'update')->name('user.update');
      Route::get('user/profile', 'profile')->name('user.profile');
      Route::get('user/profile/{username}', 'show')->name('user.show');
      Route::put('user/profile/photo/change', 'changePhoto')->name('user.change.photo');
   });

   Route::post('tiny-editor/upload', [TinyEditorController::class, 'upload'])->name('tiny-editor.upload');
   Route::resource('sample-crud', SampleCrudController::class);


  
   Route::get('dashboard', [DashboarddController::class, 'index'])->name('klinik.dashboard.index');

   Route::get('report/report1', [ReportLaporanController::class, 'report1'])->name('report.report1.index');
   Route::get('report/report1/print', [ReportLaporanController::class, 'report1Print'])->name('report.report1.print');
  



});


