<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name) ?: 'category-' . time() . '-' . uniqid();
            }
        });

        static::updating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name) ?: 'category-' . time() . '-' . uniqid();
            }
        });
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset($this->image);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
