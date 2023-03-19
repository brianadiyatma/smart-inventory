<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCMToken extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'fcm_tokens';
    protected $guarded = ['id'];
}
