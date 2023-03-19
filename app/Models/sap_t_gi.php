<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sap_t_gi extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public function details()
    {
        return $this->hasMany(sap_t_gi_dtl::class, 'gi_id', 'id');
    }

    public function proyek()
    {
        return $this->belongsTo(sap_m_project::class, 'project_code', 'project_code');
    }
}
