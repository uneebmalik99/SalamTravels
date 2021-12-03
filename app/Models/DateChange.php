<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateChange extends Model
{
    use HasFactory;
    public $table = 'datechange';
    protected $fillable = [
      'airline_name', 'pnr', 'booking_source', 'sector', 'newdate', 'passenger_name','remarks', 'user_id'
    ];
}
