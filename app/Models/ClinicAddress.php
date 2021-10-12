<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicAddress extends Model
{
    use HasFactory;
    protected $fillable=[
        'clinic_id',
        'country_id',
        'state_id',
        'city_id',
        'zone_id',
        'area_id',
        'post_code',
        'house',
    ];
}
