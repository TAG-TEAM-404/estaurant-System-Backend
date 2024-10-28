<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['date','name','description','price','status','category_id','offer_id','image'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function offers(){
        return $this->belongsTo(Offer::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'takes')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}