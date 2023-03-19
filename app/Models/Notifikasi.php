<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifikasi extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'notifikasi';
    protected $guarded = ['id'];


    /**
     * The roles that belong to the Notifikasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_notifikasi', 'notifikasi_id', 'user_id');
    }
}
