<?php

namespace App\Http\Controllers\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterPaketSoalRequest;
use App\Models\MasterKursus;
use App\Models\MasterPaketSoal;

use App\Services\SoalServices;
use Illuminate\Support\Facades\DB;

class MasterPaketSoalController extends Controller
{
    
   protected $soalServices;

   public function __construct(SoalServices $soalServices)
   {
      $this->soalServices = $soalServices;
   }


    public function index()
    {
      $data = MasterPaketSoal::with('master_kursus');

      if (request()->ajax()) {
          return datatables()->of($data)
              ->addIndexColumn()
              ->addColumn('action', function ($data) {
                  return view('app.master-paket-soal.action', compact('data'));
              })
              ->editColumn('jenis_paket', function ($data) {
                return $this->soalServices->getJenisPaketColor($data->jenis_paket);
            })
            ->addColumn('kursus', function ($data) {
               return $data->master_kursus->judul;
           })
           ->editColumn('durasi', function ($data) {
            return  $this->soalServices->durasiFormatDetik($data->durasi)." Detik";
        })
            ->editColumn('active', function ($data) {
               return $this->soalServices->getActiveColor($data->active);
           })
              ->rawColumns(['jenis_paket','active'])
              ->make(true);
      }

      return view('app.master-paket-soal.index', compact('data'));
    }

   


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $masterKursus = MasterKursus::get();
      return view('app.master-paket-soal.create', compact('masterKursus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterPaketSoalRequest $request)
    {
        try {

            DB::beginTransaction();
            $MasterPaketSoal = MasterPaketSoal::create($request->safe()->all());
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
    public function show(MasterPaketSoal $MasterPaketSoal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   
     public function edit(MasterPaketSoal $masterPaketSoal)
     {
          $masterKursus = MasterKursus::get();
          $masterPaketSoal->with('master_kursus');
         return view('app.master-paket-soal.edit', compact('masterPaketSoal', 'masterKursus'));
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterPaketSoalRequest $request, MasterPaketSoal $masterPaketSoal)
    {
      try {

         DB::beginTransaction();
        
         $masterPaketSoal->fill($request->safe()->all())->save();
         DB::commit();

         return $this->success(__('trans.crud.success'));
     } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error').$th, 400);
     }
    }

  
    public function destroy(MasterPaketSoal $masterPaketSoal)
    {
        try {
          
            DB::beginTransaction();
            $masterPaketSoal->delete();
            DB::commit();

            return $this->success(__('trans.crud.success'));
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->error(__('trans.crud.error').$th, 400);
        }
    }

    public function getByMasterKursus($masterKursusUUID){
       $master_kursus = MasterKursus::where('uuid', $masterKursusUUID)->first();
       $masterPaketSoal = MasterPaketSoal::where('master_kursus_id', $master_kursus->id)->get();
       return $masterPaketSoal;
    }
}
