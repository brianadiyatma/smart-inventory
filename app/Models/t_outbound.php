<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class t_outbound extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $guarded = ['id'];
    public function bins()
    {
        return $this->belongsTo(sap_m_storage_bin::class, 'bin_code', 'storage_bin_code');
    }

    public function materials()
    {
        return $this->belongsTo(sap_m_materials::class, 'material_code', 'material_code');
    }
    public function plants()
    {
        return $this->belongsTo(sap_m_plant::class, 'plant_code', 'plant_code');
    }
    public function bpm()
    {
        return $this->belongsTo(sap_t_bpm::class, 'bpm_id', 'id');
    }
    public function storloc()
    {
        return $this->belongsTo(sap_m_storage_locations::class, 'storloc_code', 'storage_location_code');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function wbs()
    {
        return $this->belongsTo(sap_m_wbs::class, 'wbs_code', 'wbs_code');
    }
}
