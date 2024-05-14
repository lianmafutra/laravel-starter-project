<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KuisUserSoal extends Model
{
   use HasFactory;
   
 
    protected $table = 'kuis_user_soal';
 
    protected $guarded = [];
 
  

   
   //  protected $casts = [
   //      'created_at' => 'datetime:d/m/Y H:m:s',
   //      'updated_at' => 'datetime:d/m/Y  H:m:s',
   //  ];

    /**
     * Get all of the kuis_jawaban for the KuisUserSoal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kuis_jawaban(): HasMany
    {
        return $this->hasMany(KuisUserJawaban::class, 'kuis_user_soal_id', 'id');
    }
}
