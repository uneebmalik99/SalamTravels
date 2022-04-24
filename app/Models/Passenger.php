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
}
