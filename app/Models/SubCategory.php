<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Traits\ImageUploadTrait;

class SubCategory extends Model
{
    use HasTranslations, ImageUploadTrait;

    protected $translatable = ['name', 'description'];
    protected $fillable = ['category_id', 'name', 'description', 'slug', 'image', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
