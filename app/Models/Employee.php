<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=[
      'clinic_id',
      'department_id',
      'user_id',
      'post_name',
      'employment_status'
    ];
}
