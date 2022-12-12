<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabtype extends Model
{
    use HasFactory;
    public $table = 'tabtype';
    protected $fillable = ['tab_name'];
    public function tabtype(){
        return $this->hasMany(Tabinfo::class);
    }
}
