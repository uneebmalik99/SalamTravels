<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    use HasFactory;
    public $table = 'payment_history';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function passenger()
    {
        return $this->belongsTo(Passenger::class, 'passenger_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}