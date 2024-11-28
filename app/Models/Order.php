<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }


}
