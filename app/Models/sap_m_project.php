<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_m_project extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [''];
    
    public function wbs(){
    	return $this->hasMany(sap_m_wbs::class,'project_id','id');
    }

    public function sttp(){
    	return $this->hasMany(sap_t_sttp::class,'project_code','id');
    }
}
