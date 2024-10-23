<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['order_date','total_amount','user_id','table_id'];
    public function tables(){
        return $this->belongsTo(Table::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasOne(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An order can have many menu items through the pivot table
    public function take()
    {
        return $this->belongsToMany(Item::class, 'takes')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
  

}