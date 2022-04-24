<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $table = 'customer';
    protected $fillable = [
      'contact', 'email', 'phone', 'agency_name', 'mobile', 'credit_limit','balance', 'password', 'visiting_card', 'agency_picture'
    ];
}
