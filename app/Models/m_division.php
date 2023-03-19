<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class m_division extends Model
{
    use HasFactory;
    // use SoftDeletes;

    public function user(){
    	return $this->hasMany(User::class,'division_code','id');
    }
}
