<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisUserJawaban extends Model
{
   use HasFactory;
   use AutoUUID;
   
 
   protected $table = 'kuis_user_jawaban';

   protected $guarded = [];

 

  
   protected $casts = [
       'created_at' => 'datetime:d/m/Y H:m:s',
       'updated_at' => 'datetime:d/m/Y  H:m:s',
   ];
}
