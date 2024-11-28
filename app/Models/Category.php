<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @method static create(array $data)
 */
class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected $appends = ['banner_url', 'icon_url'];

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner ? Storage::url($this->banner) : null;
    }


    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? Storage::url($this->icon) : null;
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->select(['id', 'parent_id', 'name', 'slug', 'icon']);
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with(['childrenRecursive']);
    }
}
