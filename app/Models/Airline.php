<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;
    public $table = 'airline';
    protected $fillable = ['airline_name'];
    public $timestamps = false;
    public function tabinfos(){
        return $this->hasMany(Tabinfo::class, 'id');
    }
}
