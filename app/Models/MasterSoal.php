<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterSoal extends Model
{
   use HasFactory;

   use AutoUUID;

   protected $table = 'master_soal';

   protected $guarded = [];

   protected $hidden = ['id'];

   public function getRouteKeyName()
   {
       return 'uuid';
   }

  
   protected $casts = [
       'created_at' => 'datetime:d/m/Y H:m:s',
       'updated_at' => 'datetime:d/m/Y  H:m:s',
   ];

   public function master_paket_soal(): BelongsTo
   {
       return $this->belongsTo(MasterPaketSoal::class, 'master_paket_soal_id', 'id');
   }

   /**
    * Get all of the comments for the MasterSoal
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function master_jawaban(): HasMany
   {
       return $this->hasMany(MasterJawaban::class, 'master_soal_id', 'id');
   }

  
}
