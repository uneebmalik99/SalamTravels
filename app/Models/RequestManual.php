<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestManual extends Model
{
    use HasFactory;
    public $table = 'request_manual';
    public function processed_by()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
