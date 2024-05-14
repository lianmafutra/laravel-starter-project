<?php

namespace App\Models;

use App\Utils\AutoUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterJawaban extends Model
{
    use HasFactory;
    use AutoUUID;
    protected $table = 'master_jawaban';
 
    protected $guarded = [];
 
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:m:s',
        'updated_at' => 'datetime:d/m/Y  H:m:s',
    ];

    /**
     * Get the user that owns the MasterJawaban
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function master_soal(): BelongsTo
    {
        return $this->belongsTo(MasterSoal::class, 'master_soal_id', 'id');
    }
}
