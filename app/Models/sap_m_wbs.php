<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_m_wbs extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [''];

    public function project(){
    	return $this->belongsTo(sap_m_project::class,'project_id','id');
    }
    public function sttpDtl(){
    	return $this->hasMany(sap_t_sttp_dtl::class,'wbs_code','id');
    }
}
