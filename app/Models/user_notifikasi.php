<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_notifikasi extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'user_notifikasi';

    public function Rnotif(){
    	return $this->belongsTo(Notifikasi::class,'notifikasi_id','id');
    }
    public function Rnotifuser(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
