<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    public function tabinfo()
    {
        return $this->belongsTo(Tabtype::class, 'tabinfo_id');
    }
    public function processed()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function price(){
        return $this->hasOne(Price::class,'passenger_id','id');
    }
    public function vendor(){
        return $this->hasOne(Vendor::class,'passenger_id','id');
    }
    public function paymentHistory(){
        return $this->hasOne(PaymentHistory::class,'passenger_id','id');
    }
}
