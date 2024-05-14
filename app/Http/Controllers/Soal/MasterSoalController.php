<?php

namespace App\Http\Controllers\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterPaketSoalRequest;
use App\Http\Requests\MasterSoalRequest;
use App\Models\MasterSoal;

use App\Models\MasterKursus;
use App\Models\MasterPaketSoal;
use App\Services\SoalServices;
use App\Utils\StringUtils;
use Illuminate\Support\Facades\DB;

class MasterSoalController extends Controller
{
   protected $soalServices;

   public function __construct(SoalServices $soalServices)
   {
      $this->soalServices = $soalServices;
   }

   public function index()
   {
      
     $data = MasterSoal::with('master_paket_soal','master_paket_soal.master_kursus');

     if (request()->ajax()) {
         return datatables()->of($data)
             ->addIndexColumn()
             ->addColumn('action', function ($data) {
                 return view('app.master-soal.action', compact('data'));
             }) 
             ->addColumn('master_paket_soal', function ($data) {
            return $data->master_paket_soal->judul;
           }) 
           ->addColumn('master_kursus', function ($data) {
            return $data->master_paket_soal->master_kursus->judul;
           }) 
           ->editColumn('text_soal', function ($data) {
            return StringUtils::limitTextWithReadMore($data->text_soal,100,"...");
           }) 
           ->editColumn('active', function ($data) {
            return $this->soalServices->getActiveColor($data->active);
        })
             ->rawColumns(['text_soal','active'])
             ->make(true);
     }

     return view('app.master-soal.index', compact('data'));
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $masterKursus = MasterKursus::get();
      $masterPaketSoal = MasterPaketSoal::get();
      return view('app.master-soal.create', compact('masterPaketSoal', 'masterKursus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterSoalRequest $request)
    {
      try {

         DB::beginTransaction();
     
         $MasterSoal = MasterSoal::create($request->safe()->except('master_kursus_id'));
         DB::commit();

         return $this->success(__('trans.crud.success'));
     } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error').$th, 400);
     }
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterSoal $masterSoal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSoal $masterSoal)
    {
      $masterKursus = MasterKursus::get();
      $masterPaketSoal = MasterPaketSoal::get();
      $masterSoal->with('master_paket_soal','master_paket_soal.master_kursus');
    
     return view('app.master-soal.edit', compact('masterSoal','masterPaketSoal', 'masterKursus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterSoalRequest $request, MasterSoal $masterSoal)
    {
      try {

         DB::beginTransaction();
     
         $masterSoal->fill($request->safe()->except('master_kursus_id'))->save();
         DB::commit();

         return $this->success(__('trans.crud.success'));
     } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error').$th, 400);
     }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterSoal $masterSoal)
    {
      try {
          
         DB::beginTransaction();
         $masterSoal->delete();
         DB::commit();

         return $this->success(__('trans.crud.success'));
     } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error').$th, 400);
     }
    }
}
