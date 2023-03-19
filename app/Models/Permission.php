<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as ModelsPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends ModelsPermission
{
    // use SoftDeletes;
    protected $guarded = [];
}