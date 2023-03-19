<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_t_bpm extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [''];

    /**
     * Get all of the comments for the sap_t_bpm
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(sap_t_bpm_dtl::class, 'bpm_id', 'id');
    }
    public function outbounds()
    {
        return $this->hasMany(t_outbound::class, 'bpm_id', 'id');
    }
    public function destination()
    {
        return $this->belongsTo(sap_m_storage_locations::class, 'storage_location_code', 'storage_location_code');
    }
}
