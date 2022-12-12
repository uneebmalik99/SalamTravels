<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabtypelink extends Model
{
    use HasFactory;
    public $table = 'tabtypelink';
    public $timestamps = false;
    public function tabtype(){
        return $this->belongsTo(Tabtype::class, 'tabtype_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
