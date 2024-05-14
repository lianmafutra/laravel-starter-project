<?php

namespace App\Services;


class SoalServices
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

   public function durasiFormatDetik($durasi)
   {
      return number_format($durasi, 0, ',', '.');
   }

   public function durasiFormatMenit($durasi)
   {
      return number_format($durasi, 0, ',', '.');
   }


}
