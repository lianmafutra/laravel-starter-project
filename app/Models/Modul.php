<?php

namespace App\Models;

use App\Utils\AutoUUID;
use App\Utils\LmFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Modul extends Model
{
   use HasFactory;

   use LmFileTrait;
   use AutoUUID;

   protected $table = 'modul';

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

   public function file_modul_r(): HasOne
   {
       return $this->hasOne(File::class, 'file_id', 'file_modul')->withDefault();
   }

 
}
