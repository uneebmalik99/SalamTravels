<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public $table = 'payment';
    protected $fillable = [
        'amount', 'bank', 'payment_date', 'payment_proof', 'remarks', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank');
    }
}
