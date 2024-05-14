<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class MasterKursusServices
{

   public function getActiveColor($active)
   {
       $color = '';
       switch ($active) {
          case 'true':
             $color = 'primary';
             break;
          case 'false':
             $color = 'secondary';
             break;
       }
       return '<td  data-order='.$active.'><span class="badge badge-'.$color.' right">'.$active.'</span></td>';
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
