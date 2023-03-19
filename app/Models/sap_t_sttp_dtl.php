<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_t_sttp_dtl extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [];
    
    public function sttp(){
        return $this->belongsTo(sap_t_sttp::class,'sttp_id','id');
    }

    public function wbs(){
    	return $this->belongsTo(sap_m_wbs::class,'wbs_code','wbs_code');
    }

    public function material(){
    	return $this->belongsTo(sap_m_materials::class,'material_code','material_code');
    }
}
