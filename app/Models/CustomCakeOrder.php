<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomCakeOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['photo_on_cake_url'];
    public function getPhotoOnCakeUrlAttribute(): ?string
    {
        return $this->photo_on_cake ? Storage::url('photo_on_cakes/' . $this->photo_on_cake) : null;
    }

    public function custom_cake()
    {
        return $this->belongsTo(CustomCake::class);
    }
    public function custom_cake_customer()
    {
        return $this->belongsTo(CustomCakeCustomer::class);
    }
    public function custom_cake_flavor()
    {
        return $this->belongsTo(CustomCakeFlavor::class);
    }

    public function custom_cake_order_images()
    {
        return $this->hasMany(CustomCakeOrderImage::class);
    }



}
