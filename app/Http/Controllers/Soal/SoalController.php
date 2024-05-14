<?php

namespace App\Http\Controllers\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\generateSoalUserRequest as RequestsGenerateSoalUserRequest;
use App\Http\Requests\UpdateJawabanRequest;
use App\Models\generateSoalUserRequest;
use App\Models\KuisUser;
use App\Models\KuisUserJawaban;
use App\Models\KuisUserSoal;
use App\Models\MasterPaketSoal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SoalController extends Controller
{
   public function listPaketSoal()
   {
      $masterPaketSoal =  MasterPaketSoal::get();
      return view('app.soal.list-paket-soal', compact('masterPaketSoal'));
   }

   public function kerjakanKuis($paket_soal_uuid)
   {

      $paketSoal = MasterPaketSoal::with('master_kursus')->where('uuid', $paket_soal_uuid)->first();

      return view('app.soal.kuis', compact('paketSoal'));
   }

   public function kuisUserSoalAll($kuis_user_id)
   {


      $kuisUser = KuisUser::with('kuis_user_soal', 'kuis_user_soal.kuis_jawaban', 'master_paket_soal')
         ->where('id', $kuis_user_id)
         ->where('user_id', auth()->user()->id)->first();

      $created_at = Carbon::parse($kuisUser->created_at);


      $expired_at = $created_at->addSeconds(3600);


      $sisa_waktu = Carbon::now()->diffInSeconds($expired_at, false);
      // Menambahkan nilai baru
      $kuisUser->waktu_sisa = $sisa_waktu;

      $kuisUserArray = $kuisUser->toArray();
      $kuisUserArray['waktu_sisa'] = $sisa_waktu;



      return response()->json($kuisUserArray);
   }

   public function kuisUserSoalSingle($kuis_user_id, $nomor_urut)
   {

      sleep(0.5);
      $masterPaketSoal =
         KuisUserSoal::with('kuis_jawaban')
         ->where('kuis_user_id', $kuis_user_id)
         ->where('nomor_urut', $nomor_urut)->first();



      return response()->json($masterPaketSoal);
   }

   public function generateSoalUser(
      $master_paket_soal_uuid,
      RequestsGenerateSoalUserRequest $generateSoalUserRequest
   ) {

      try {
         DB::beginTransaction();
         $kuisUserCheck =  KuisUser::where('finished_at', NULL)->exists();

         if ($kuisUserCheck == false) {
            $masterPaketSoal = MasterPaketSoal::with(['soal.master_jawaban', 'soal' => function ($query) {
               $query->inRandomOrder();
            }])->where('uuid', $master_paket_soal_uuid)->first();
            $kuisUser =  KuisUser::create($generateSoalUserRequest->safe()->all());

            foreach ($masterPaketSoal->soal as $key => $value) {

               $kuisUserSoal =  KuisUserSoal::create([
                  "text_soal"    => $value->text_soal,
                  "kuis_user_id" => $kuisUser->id,
                  "nomor_urut"   =>  $key + 1
               ]);


               foreach ($value->master_jawaban->toArray() as $key2 => $value2) {

                  KuisUserJawaban::create([
                     "text_jawaban"    => $value2['text_jawaban'],
                     "kuis_user_soal_id" => $kuisUserSoal->id,
                     "nomor_urut"   =>  $key2 + 1
                  ]);
               }
            }
         } else {
            $kuisUser =  KuisUser::with('kuis_user_soal')->where('finished_at', NULL)->first();
         }


         DB::commit();
         return response()->json($kuisUser);
      } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error') . $th, 400);
      }
   }


   function updateJawaban($kuis_user_jawaban_id)
   {

      try {
         DB::beginTransaction();

         $jawaban = KuisUserJawaban::find($kuis_user_jawaban_id);

         KuisUserSoal::where('id', $jawaban->kuis_user_soal_id)
            ->update(['jawaban_dipilih' => json_encode([$jawaban->id])]);

         DB::commit();
         return $this->success("Berhasil Update Jawaban", "");
      } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error') . $th, 400);
      }
   }

   function submitAkhirKuis($kuis_user_id)
   {
      // update untuk menandakan waktu kuis telah selesai
      KuisUser::where('id', $kuis_user_id)
         ->update(['finished_at' => Carbon::now()]);


   }
}
