<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;
    public $table = 'ticket_type';
    public function ledger()
    {
        return $this->hasMany(Ledger::class);
    }
}
