<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @method static create(array $data)
 */
class Review extends Model
{
    use HasFactory;

    protected $guarded = ['id'];



    protected $appends = ['profile_image'];

    public function getProfileImageAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }
    protected $casts = [
        'created_at' => "datetime:Y-m-d",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
