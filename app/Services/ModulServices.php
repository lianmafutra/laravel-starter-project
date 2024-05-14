<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ModulServices
{
   public function getJenisPaketColor($jenis_paket)
   {
       $color = '';
       switch ($jenis_paket) {
          case 'Free':
             $color = 'success';
             break;
          case 'Premium':
             $color = 'warning';
             break;
       }
       return '<td  data-order='.$jenis_paket.'><span class="badge badge-'.$color.' right">'.$jenis_paket.'</span></td>';
   }

   public function getCover($url)
   {
      $file = $url->file_cover_r;
      if ($file) {
         $file = url(Storage::url($file->path.$file->name_hash));
     } else {
      $file= asset('img/avatar2.png');
     }

     return '<img  class="  p-0" src="'.$file.'" height="90px" width="80px" ;="" style="object-fit: cover; padding: 0px !important;">';

      
   }
}
