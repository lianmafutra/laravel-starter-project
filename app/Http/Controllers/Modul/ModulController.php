<?php

namespace App\Http\Controllers\Modul;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModulRequest;
use App\Models\Modul;
use App\Services\ModulServices;
use Illuminate\Support\Facades\DB;

class ModulController extends Controller
{
   protected $modulServices;

   public function __construct(ModulServices $modulServices)
   {
      $this->modulServices = $modulServices;
   }

    public function index(){

      $data = Modul::with('file_cover_r','file_modul_r');

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('app.modul.action', compact('data'));
                })
                ->addColumn('file_cover', function ($data) {
                    return $this->modulServices->getCover($data);
                })
                ->editColumn('jenis_paket', function ($data) {
                  return $this->modulServices->getJenisPaketColor($data->jenis_paket);
              })
                ->rawColumns(['jenis_paket','file_cover'])
                ->make(true);
        }

        return view('app.modul.modul-index', compact('data'));
    }

    public function create()
    {
        return view('app.modul.create');
    }


      public function store(ModulRequest $request)
      {
          try {
  
              DB::beginTransaction();
           
              $modul = Modul::create($request->safe()->except('file_cover', 'file_modul'));
  
              Modul::find($modul->id)
                  ->addFile($request->file_modul)
                  ->path('file_modul')
                  ->field('file_modul')
                  ->extension(['pdf','docx','doc','xls','xlsx'])
                  ->storeFile();
  
                  Modul::find($modul->id)
                  ->addFile($request->file_cover)
                  ->path('cover')
                  ->field('file_cover')
                  ->extension(['jpg', 'png'])
                  ->withThumb(100)
                  ->compress(60)
                  ->storeFile();
  
              DB::commit();
  
              return $this->success(__('trans.crud.success'));
          } catch (\Throwable $th) {
              DB::rollBack();
  
              return $this->error(__('trans.crud.error').$th, 400);
          }
      }

      public function edit(Modul $modul)
      {
        
          return view('app.modul.edit', compact('modul'));
      }

      public function update(ModulRequest $request, Modul $modul)
      {
          try {
  
              DB::beginTransaction();
  
              $modul->fill($request->safe()->except('file_cover', 'file_modul'))->save();
  
              Modul::find($modul->id)
              ->addFile($request->file_modul)
              ->path('file_modul')
              ->field('file_modul')
              ->extension(['pdf','docx','doc','xls','xlsx'])
              ->updateFile();

              Modul::find($modul->id)
              ->addFile($request->file_cover)
              ->path('file_cover')
              ->field('file_cover')
              ->extension(['jpg', 'png'])
              ->withThumb(100)
              ->compress(60)
              ->updateFile();
  
              DB::commit();
              return $this->success(__('trans.crud.success'));
          } catch (\Throwable $th) {
              DB::rollBack();
  
              return $this->error(__('trans.crud.error').$th, 400);
          }
      }

      public function destroy(Modul $modul)
      {
          try {
          
              DB::beginTransaction();
              $modul->deleteWithFile();
              DB::commit();
  
              return $this->success(__('trans.crud.success'));
          } catch (\Throwable $th) {
              DB::rollBack();
  
              return $this->error(__('trans.crud.error').$th, 400);
          }
      }
}
