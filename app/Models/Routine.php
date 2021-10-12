<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id',
      'from_time',
        'to_time',
        'day',
        'clinic_id'
    ];
}
