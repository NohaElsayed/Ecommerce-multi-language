<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Traits\ImageUploadTrait;

class Product extends Model
{
    use HasTranslations, ImageUploadTrait;

    protected $translatable = ['name', 'description', 'short_description'];
    protected $fillable = [
        'category_id', 'sub_category_id', 'name', 'description', 'short_description',
        'slug', 'sku', 'price', 'sale_price', 'stock', 'image', 'gallery',
        'is_featured', 'is_active'
    ];
    protected $casts = ['gallery' => 'array', 'is_featured' => 'boolean', 'is_active' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('stock', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['category'] ?? null, fn($q) => $q->where('category_id', $filters['category']))
            ->when($filters['sub_category'] ?? null, fn($q) => $q->where('sub_category_id', $filters['sub_category']))
            ->when($filters['min_price'] ?? null, fn($q) => $q->where('price', '>=', $filters['min_price']))
            ->when($filters['max_price'] ?? null, fn($q) => $q->where('price', '<=', $filters['max_price']))
            ->when($filters['search'] ?? null, function($q) use ($filters) {
                $q->where(function($sub) use ($filters) {
                    $sub->where('name', 'like', "%{$filters['search']}%")
                        ->orWhere('sku', 'like', "%{$filters['search']}%");
                });
            })
            ->when($filters['featured'] ?? null, fn($q) => $q->where('is_featured', true))
            ->when($filters['sort'] ?? null, function($q) use ($filters) {
                match($filters['sort']) {
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'newest' => $q->orderBy('created_at', 'desc'),
                    default => $q->orderBy('id', 'asc')
                };
            });
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }
}
