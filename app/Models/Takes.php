<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Takes extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'item_id', 'quantity', 'count'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

  
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
