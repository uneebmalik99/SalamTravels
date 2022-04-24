<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tabinfo extends Model
{
    use HasFactory;
    public $table = 'tabinfo';
    protected $fillable = [
        'airline_id', 'pnr', 'booking_source_id', 'sector', 'date', 'passenger_name', 'remarks', 'status_id', 'user_id', 'tabtype_id'
    ];
    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }
    public function booking_source()
    {
        return $this->belongsTo(Booking::class, 'booking_source_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tabtype()
    {
        return $this->belongsTo(Tabtype::class, 'tabtype_id');
    }
    public function ledger()
    {
        return $this->hasOne(Ledger::class);
    }
    public function passenger()
    {
        return $this->hasOne(Passenger::class);
    }
    // public function processed_by()
    // {
    //     return $this->belongsTo(User::class, 'processed_by');
    // }
}
