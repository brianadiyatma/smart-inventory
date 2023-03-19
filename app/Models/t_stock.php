<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class t_stock extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = ['id'];
    
    public function Rmaterial(){
        return $this->belongsTo(sap_m_materials::class,'material_code','material_code');
    }

    public function Rplant(){
        return $this->belongsTo(sap_m_plant::class,'plant_code','plant_code');
    }

    public function Rstorloc(){
        return $this->belongsTo(sap_m_storage_locations::class,'storloc_code','storage_location_code');
    }

    public function Rstoragetype(){
    	return $this->belongsTo(sap_m_storage_type::class,'storage_type_code','storage_type_code');
    }

    public function Rbin(){
        return $this->belongsTo(sap_m_storage_bin::class,'bin_code','storage_bin_code');
    }

    public function Rproject(){
        return $this->belongsTo(sap_m_project::class,'special_stock_number','project_code');
    }
}
