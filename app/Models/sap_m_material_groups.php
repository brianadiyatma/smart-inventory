<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_m_material_groups extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $guarded = [''];

    public function materials(){
    	return $this->hasMany(sap_m_materials::class,'material_group_id','id');
    }
    
}
