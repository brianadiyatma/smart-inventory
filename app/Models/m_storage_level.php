<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class m_storage_level extends Model
{
    use HasFactory;
    // use SoftDeletes;    

    protected $guarded = [];
    public $timestamps = false;

    public function type(){
    	return $this->belongsTo(sap_m_storage_types::class,'storage_type_code','storage_type_code');
    }

    public function plant(){
    	return $this->belongsTo(sap_m_plants::class,'plant_code','plant_code');
    }

    public function location(){
    	return $this->belongsTo(sap_m_storage_locations::class,'storloc_code','storage_location_code');
    }

    public function bin(){
    	return $this->belongsTo(sap_m_storage_bins::class,'bin_code','storage_bin_code');
    }
}
