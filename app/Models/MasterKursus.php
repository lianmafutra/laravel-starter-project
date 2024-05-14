<?php

namespace App\Models;

use App\Utils\AutoUUID;
use App\Utils\LmFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MasterKursus extends Model
{
   use HasFactory;

   use LmFileTrait;
   use AutoUUID;

   protected $table = 'master_kursus';

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

   
   public function file_cover_r(): HasOne
   {
       return $this->hasOne(File::class, 'file_id', 'file_cover')->withDefault();
   }

   /**
    * Get all of the comments for the MasterKursus
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function master_paket_soal(): HasMany
   {
       return $this->hasMany(MasterPaketSoal::class, 'master_kursus_id', 'id');
   }


}
