<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @method static create(array $array)
 */
class Slider extends Model
{
    use HasFactory;

    protected $appends =['image_url'];
    protected $guarded = ['id'];


    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

}
