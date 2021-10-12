<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable=[
      'user_id',
      'appointment_id',
      'doctor_id',
      'prescription_id',
      'description',
        'doctor_fee',
        'other_fee',
        'total',
      'discount',
        'final_total',
      'payment_status',
        'prepared_by'
    ];
}
