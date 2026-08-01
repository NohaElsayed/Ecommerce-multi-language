<?php

namespace App\Services;

use App\Models\Product;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;

class ProductService
{
    use ImageUploadTrait;

    /**
     * جلب جميع المنتجات مع الفلترة والترقيم
     */
    public function getAll(array $filters = [], int $perPage = 12)
    {
        $perPage = request('per_page', $perPage);
        $perPage = in_array($perPage, [12, 24, 36, 48]) ? $perPage : 12;

        return Product::active()->filter($filters)->paginate($perPage);
    }

    /**
     * إيجاد منتج بالـ ID
     */
    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * ✅ إنشاء منتج جديد
     */
    public function create(array $data): Product
    {
        // إنشاء الـ Slug
        $data['slug'] = Str::slug($data['name']['en'] ?? now()->timestamp) . '-' . uniqid();

        // رفع الصورة الرئيسية
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'products');
        }

        // رفع صور المعرض
        if (isset($data['gallery']) && is_array($data['gallery'])) {
            $data['gallery'] = json_encode($this->uploadMultipleImages($data['gallery'], 'products/gallery'));
        } else {
            $data['gallery'] = json_encode([]);
        }

        // تحويل الحقول القابلة للترجمة إلى JSON
        $data['name'] = json_encode($data['name']);
        $data['description'] = json_encode($data['description']);
        $data['short_description'] = json_encode($data['short_description'] ?? []);

        // تعيين القيم الافتراضية للـ booleans
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['is_active'] = $data['is_active'] ?? true;

        return Product::create($data);
    }

    /**
     * ✅ تحديث منتج موجود
     */
    public function update(Product $product, array $data): Product
    {
        // تحديث الصورة الرئيسية
        if (isset($data['image']) && $data['image']) {
            $data['image'] = $this->updateImage($data['image'], $product->getRawOriginal('image'), 'products');
        } else {
            unset($data['image']);
        }

        // تحديث صور المعرض
        if (isset($data['gallery']) && is_array($data['gallery']) && count($data['gallery']) > 0) {
            // حذف الصور القديمة
            $oldGallery = json_decode($product->getRawOriginal('gallery'), true) ?? [];
            foreach ($oldGallery as $old) {
                $this->deleteImage($old);
            }
            $data['gallery'] = json_encode($this->uploadMultipleImages($data['gallery'], 'products/gallery'));
        } else {
            unset($data['gallery']);
        }

        // تحويل الحقول القابلة للترجمة إلى JSON
        foreach (['name', 'description', 'short_description'] as $field) {
            if (isset($data[$field])) {
                $data[$field] = json_encode($data[$field]);
            }
        }

        // تعيين القيم الافتراضية للـ booleans
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['is_active'] = $data['is_active'] ?? true;

        $product->update($data);
        return $product->fresh();
    }

    /**
     * ✅ حذف منتج
     */
    public function delete(Product $product): bool
    {
        // 1. حذف الصورة الرئيسية
        $this->deleteImage($product->getRawOriginal('image'));

        // 2. حذف صور المعرض بأمان (فك تشفير JSON إلى Array)
        $gallery = json_decode($product->getRawOriginal('gallery'), true) ?? [];

        if (is_array($gallery)) {
            foreach ($gallery as $img) {
                $this->deleteImage($img);
            }
        }

        return $product->delete();
    }

    /**
     * ✅ جلب المنتجات المميزة
     */
    public function getFeaturedProducts(int $limit = 8)
    {
        return Product::active()
            ->featured()
            ->with(['category', 'subCategory'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * ✅ جلب أحدث المنتجات
     */
    public function getNewArrivals(int $limit = 8)
    {
        return Product::active()
            ->with(['category', 'subCategory'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * ✅ جلب الأكثر مبيعاً
     */
    public function getBestSellers(int $limit = 8)
    {
        return Product::active()
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * ✅ جلب المنتجات المشابهة
     */
    public function getRelatedProducts(Product $product, int $limit = 4)
    {
        return Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit($limit)
            ->get();
    }
}
