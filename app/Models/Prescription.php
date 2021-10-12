<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable=[
      'user_id',
      'clinic_id',
      'department_id',
      'appointment_id',
      'description',
        'doctor_id'
    ];
}
