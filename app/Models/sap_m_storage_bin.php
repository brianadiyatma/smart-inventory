<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_m_storage_bin extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public function plant()
    {
        return $this->belongsTo(sap_m_plant::class, 'plant_code', 'plant_code');
    }
    public function type()
    {
        return $this->belongsTo(sap_m_storage_type::class, 'storage_type_code', 'storage_type_code');
    }
    public function loc()
    {
        return $this->belongsTo(sap_m_storage_locations::class, 'storage_loc_code', 'storage_location_code');
    }
    protected $guarded = [''];
}
