<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    public $table = 'bookings';
    protected $fillable = ['booking_source'];
    public $timestamps = false;
    public function tabinfo(){
        return $this->hasMany(Tabinfo::class);
    }
}
