<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = ['description','percentage','start_date','end_date'];
    public function items(){
        return $this->hasMany( Item::class);
}
}