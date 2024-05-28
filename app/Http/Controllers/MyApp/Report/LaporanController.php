<?php

namespace App\Http\Controllers\MyApp\Report;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
   public function report1()
   {

      return view('app.report.report1');
   }

   public function report1Print(Request $request)
   {

      $start_date = urldecode(request()->get('start_date'));
      $end_date = urldecode(request()->get('end_date'));

      $startDate = Carbon::createFromFormat('d/m/Y', urldecode(request()->get('start_date')))->translatedFormat('Y/m/d');
      $endDate = Carbon::createFromFormat('d/m/Y', urldecode(request()->get('end_date')))->translatedFormat('Y/m/d');


      dd($request->all());

      if (request()->get('jenis_laporan') == "all") {
        
      }
      if (request()->get('jenis_laporan') == "user") {
       
      }

      // $data =  Model::whereBetween('created_at', [$startDate, $endDate])->get();


      return view('app.report.report1-print', compact('data', 'start_date', 'end_date'));
   }

 


  
}
