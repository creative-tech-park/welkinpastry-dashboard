<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 */
class Address extends Model
{
    use HasFactory;


    protected $table = "customer_addresses";
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderArea(){
        return $this->belongsTo(OrderArea::class, 'shipping_area_id');
    }

}
