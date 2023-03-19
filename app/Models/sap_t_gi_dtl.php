<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_t_gi_dtl extends Model
{
    use HasFactory;
    // use SoftDeletes;
    
    public function gi(){
    	return $this->belongsTo(sap_t_gi::class,'gi_id','id');
    }
    
    public function Rstorloc()
    {
        return $this->belongsTo(sap_m_storage_locations::class, 'storloc_code', 'storage_location_code');
    }
    public function material(){
    	return $this->belongsTo(sap_m_materials::class,'material_code','material_code');
    }
}
