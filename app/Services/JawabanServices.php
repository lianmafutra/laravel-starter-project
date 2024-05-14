<?php

namespace App\Services;


class JawabanServices
{
 


   public function getNilaiJawabanColor($active)
   {
       $color = '';
       switch ($active) {
          case 'benar':
             $color = 'success';
             break;
          case 'salah':
             $color = 'secondary';
             break;
       }
       return '<td  data-order='.$active.'><span class="badge badge-'.$color.' right">'.$active.'</span></td>';
   }


}
