<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_t_bpm_dtl extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [''];

    public function bpm(){
    	return $this->belongsTo(sap_t_bpm::class,'bpm_id','id');
    }
    
    public function wbs(){
    	return $this->belongsTo(sap_m_wbs::class,'wbs_code','wbs_code');
    }

    public function material(){
    	return $this->belongsTo(sap_m_materials::class,'material_code','material_code');
    }

    public function plant(){
    	return $this->belongsTo(sap_m_plant::class,'plant_code','plant_code');
    }

    public function uom(){
    	return $this->belongsTo(sap_m_uoms::class,'uom_code','uom_code');
    }
}
