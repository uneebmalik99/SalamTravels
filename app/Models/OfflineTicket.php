<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineTicket extends Model
{
    use HasFactory;
    public $table = 'offlineticket';
    protected $fillable = [
      'airline_name', 'pnr', 'booking_source', 'sector', 'date', 'passenger_name','remarks', 'user_id'
    ];
}
