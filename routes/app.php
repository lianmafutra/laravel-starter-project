<?php

use App\Http\Controllers\Account\UpgradeAccountController;
use App\Http\Controllers\Admin\TinyEditorController;
use App\Http\Controllers\BerandaController;

use App\Http\Controllers\DataUserController;
use App\Http\Controllers\Jawaban\MasterJawabanController;
use App\Http\Controllers\Kursus\MasterKursusController;
use App\Http\Controllers\Modul\ModulController;
use App\Http\Controllers\SampleCrudController;
use App\Http\Controllers\Soal\MasterPaketSoalController;
use App\Http\Controllers\Soal\MasterSoalController;
use App\Http\Controllers\Soal\SoalController;
use App\Http\Controllers\UserController;
use App\Models\MasterJawaban;
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
   Route::controller(SoalController::class)
      ->group(function () {
         Route::get('paket-soal', 'listPaketSoal')->name('list-paket-soal');
         Route::get('kuis/{paket_soal_uuid}', 'kerjakanKuis')->name('kuis.user.kerjakan');
         Route::get('kuis/user/soal/{kuis_user_id}/all', 'kuisUserSoalAll')->name('kuis.user.soal.all');
         Route::get('kuis/user/soal/{kuis_user_id}/nomor-urut/{nomor_urut}', 'kuisUserSoalSingle')->name('kuis.user.soal.single');
         Route::post('paket-soal/{uuid}/soal/generate', 'generateSoalUser')->name('kuis.user.generate-soal');
         Route::put('kuis/user/soal/jawab/{kuis_user_jawaban_uuid}', 'updateJawaban')->name('kuis.user.jawab');
         Route::put('kuis/user/submit/{kuis_user_id}', 'submitAkhirKuis')->name('kuis.user.submit');
      });

   Route::controller(UpgradeAccountController::class)
      ->prefix('upgrade-account')
      ->name('upgrade-account')
      ->group(function () {
         Route::get('/', 'index')->name('index');
      });

  
   Route::resource('sample-crud', SampleCrudController::class);
   Route::resource('data-user', DataUserController::class);

   Route::resource('master-kursus', MasterKursusController::class)->parameters([
      'master-kursus' => 'masterKursus',
  ]);
  

   Route::resource('master-paket-soal', MasterPaketSoalController::class);
   Route::get('master-paket-soal/{uuid}/master-kursus', [MasterPaketSoalController::class, 'getByMasterKursus'])->name('master-paket-soal.getByMasterKursus');

   Route::resource('master-soal', MasterSoalController::class);
   Route::resource('master-jawaban', MasterJawabanController::class);

   Route::resource('modul', ModulController::class);

});
