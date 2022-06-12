<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes, HasFactory;
    public $table = 'customer';
    protected $fillable = [
        'contact', 'email', 'phone', 'agency_name', 'mobile', 'credit_limit', 'balance', 'password', 'visiting_card', 'agency_picture'
    ];
}
