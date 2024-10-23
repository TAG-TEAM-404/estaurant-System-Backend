<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['review_date','rate','comments','user_id', 'order_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A review belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}