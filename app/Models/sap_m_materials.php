<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_m_materials extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'id',
        'material_code',
        'material_desc',
        'specification',
        'uom_id',
        'material_group_id',
        'material_type_id',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [''];

    public function Rbun(){
    	return $this->belongsTo(sap_m_uoms::class,'uom_id','id');
    }

    public function type(){
    	return $this->belongsTo(sap_m_material_type::class,'material_type_id','id');
    }

    public function group(){
    	return $this->belongsTo(sap_m_material_groups::class,'material_group_id','id');
    }

}
