<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['order_date','total_amount','user_id','table_id' , 'type'];
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
    public function takes()
    {
        return $this->hasMany(Takes::class);
    }
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