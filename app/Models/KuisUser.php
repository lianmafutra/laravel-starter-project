<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KuisUser extends Model
{
    use HasFactory;
    use AutoUUID;
 
    protected $table = 'kuis_user';
 
    protected $guarded = [];
 

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y  H:i:s',
    ];

    /**
     * Get all of the comments for the KuisUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kuis_user_soal(): HasMany
    {
        return $this->hasMany(KuisUserSoal::class, 'kuis_user_id', 'id');
    }

    public function master_paket_soal(): BelongsTo
    {
        return $this->belongsTo(MasterPaketSoal::class, 'master_paket_soal_id', 'id');
    }

}
