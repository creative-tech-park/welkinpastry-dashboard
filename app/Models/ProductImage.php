<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute(): ?string
    {
        return $this->url ? Storage::url($this->url) : null;
    }


}
