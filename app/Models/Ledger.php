<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    public $table = 'ledgers';
    protected $fillable = [
        'date', 'transaction', 'agency_name', 'booking_id', 'airline_id', 'pnr', 'to', 'from', 'dep_date', 'arr_date', 'processed_by'
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }
    public function processed_by()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function tabinfo()
    {
        return $this->belongsTo(Tabtype::class, 'tabinfo_id');
    }
    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticketType_id');
    }
}
