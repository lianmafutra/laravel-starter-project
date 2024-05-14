<?php

namespace App\Http\Controllers\Jawaban;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterJawabanRequest;
use App\Models\MasterJawaban;
use App\Models\MasterSoal;
use App\Services\JawabanServices;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterJawabanController extends Controller
{
   protected $jawabanServices;
   use ApiResponse;

   public function __construct(JawabanServices $jawabanServices)
   {
      $this->jawabanServices = $jawabanServices;
   }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
     
      $soal_id = MasterSoal::where('uuid', $request->soal_uuid)->first()->id;
      $data = MasterJawaban::where('master_soal_id', $soal_id);

      if (request()->ajax()) {
          return datatables()->of($data)
              ->addIndexColumn()
              ->addColumn('action', function ($data) {
                  return view('app.master-jawaban.action', compact('data'));
              }) 
              ->editColumn('nilai_jawaban', function ($data) {
               return $this->jawabanServices->getNilaiJawabanColor($data->nilai_jawaban);
              })
              ->rawColumns(['text_jawaban','nilai_jawaban'])
              ->make(true);
      }
      return view('app.master-soal.edit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(MasterJawabanRequest $request)
    {
        try {
               
            $input = $request->safe()->except('jawaban_id');
            $masterJawaban = MasterJawaban::updateOrCreate(
                ['id' => $request->jawaban_id],
                $input
            );
            return $this->success(config('language.alert-success.store'));
        } catch (\Throwable $th) {
            return $this->error(config('language.alert-error.store').$th, 400);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(MasterJawaban $masterJawaban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterJawaban $masterJawaban)
    {
      return $this->success('Data Master Jawaban', $masterJawaban);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterJawaban $masterJawaban)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterJawaban $masterJawaban)
    {
      try {
          
         DB::beginTransaction();
         $masterJawaban->delete();
         DB::commit();

         return $this->success(__('trans.crud.delete'));
     } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error').$th, 400);
     }
    }
}
