<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\PassengerDeleted;


class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_name',
        'title',
        'type',
        'ticket',
        'remarks',
        'tabinfo_id',
    ];
    protected $dispatchesEvents  = [
        'deleting' => PassengerDeleted::class
    ];
    public function tabinfo()
    {
        return $this->belongsTo(Tabinfo::class, 'tabinfo_id');
    }

    public function processed()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function price()
    {
        return $this->hasOne(Price::class, 'passenger_id', 'id');
    }
    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'passenger_id', 'id');
    }
    public function paymentHistory()
    {
        return $this->hasOne(PaymentHistory::class, 'passenger_id', 'id');
    }
}
