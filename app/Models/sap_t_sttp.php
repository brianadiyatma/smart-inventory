<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_t_sttp extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [];
    public function proyek(){
    	return $this->belongsTo(sap_m_project::class,'project_code','project_code');
    }

    /**
     * Get all of the comments for the sap_t_sttp
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(sap_t_sttp_dtl::class, 'sttp_id', 'id');
    }

    public function inbounds()
    {
        return $this->hasMany(t_inbound::class, 'sttp_id', 'id');
    }

}
