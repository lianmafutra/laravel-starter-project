<?php

namespace App\Models;

use App\Utils\AutoUUID;
use App\Utils\LmFileTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MasterPaketSoal extends Model
{
    use HasFactory;

    use LmFileTrait;
    use AutoUUID;
 
    protected $table = 'master_paket_soal';
 
    protected $guarded = [];
 
    protected $hidden = ['id'];
 
    public function getRouteKeyName()
    {
        return 'uuid';
    }

   
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:m:s',
        'updated_at' => 'datetime:d/m/Y  H:m:s',
      //   'active' => 'boolean',
    ];

    /**
     * Get the user associated with the MasterPaketSoal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function master_kursus(): BelongsTo
    {
        return $this->belongsTo(MasterKursus::class, 'master_kursus_id', 'id');
    }

    public function soal(): HasMany
    {
        return $this->hasMany(MasterSoal::class, 'master_paket_soal_id', 'id');
    }



   
}
