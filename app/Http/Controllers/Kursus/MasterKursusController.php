<?php

namespace App\Http\Controllers\Kursus;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterKursusRequest;
use App\Models\MasterKursus;

use App\Services\MasterKursusServices;
use Illuminate\Support\Facades\DB;

class MasterKursusController extends Controller
{

   protected $masterKursusServices;

   public function __construct(MasterKursusServices $masterKursusServices)
   {
      $this->masterKursusServices = $masterKursusServices;
   }


   public function index()
   {
     $data = MasterKursus::query();

     if (request()->ajax()) {
         return datatables()->of($data)
             ->addIndexColumn()
             ->addColumn('action', function ($data) {
                 return view('app.master-kursus.action', compact('data'));
             })
           ->editColumn('active', function ($data) {
              return $this->masterKursusServices->getActiveColor($data->active);
          })
          ->addColumn('file_cover', function ($data) {
            return $this->masterKursusServices->getCover($data);
        })
             ->rawColumns(['jenis_paket','active','file_cover'])
             ->make(true);
     }

     return view('app.master-kursus.index', compact('data'));
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('app.master-kursus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MasterKursusRequest $request)
    {
      try {

          DB::beginTransaction();
       
          $masterKursus = MasterKursus::create($request->safe()->except('file_cover'));

              MasterKursus::find($masterKursus->id)
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

    /**
     * Display the specified resource.
     */
    public function show(MasterKursus $masterKursus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterKursus $masterKursus)
    {
      return view('app.master-kursus.edit', compact('masterKursus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MasterKursusRequest $request, MasterKursus $masterKursus)
    {
      try {

         DB::beginTransaction();
      
         $masterKursus->fill($request->safe()->except('file_cover'))->save();

             MasterKursus::find($masterKursus->id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterKursus $masterKursus)
    {
      try {
          
         DB::beginTransaction();
         $masterKursus->deleteWithFile();
         DB::commit();

         return $this->success(__('trans.crud.success'));
     } catch (\Throwable $th) {
         DB::rollBack();

         return $this->error(__('trans.crud.error').$th, 400);
     }
    }
}
