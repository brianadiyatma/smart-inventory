<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_movement extends Model
{
    use HasFactory;
    protected $fillable = [
    	'movement_number',
    	'material_code',
    	'plant_code',
    	'storloc_code',
    	'special_stock',
    	'special_stock_number',
    	'qty',
    	'bin_origin_code',
    	'bin_destination_code'
    ];
}
