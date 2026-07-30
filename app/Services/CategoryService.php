<?php

namespace App\Services;

use App\Models\Category;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;

class CategoryService
{
    use ImageUploadTrait;

    public function getAllCategories()
    {
        return Category::with('subCategories')->orderBy('sort_order')->get();
    }

    public function createCategory(array $data): Category
    {
        $data['slug'] = Str::slug($data['name']['en'] ?? now()->timestamp);
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'categories');
        }
        $data['name'] = json_encode($data['name']);
        $data['description'] = json_encode($data['description'] ?? []);
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        if (isset($data['image'])) {
            $data['image'] = $this->updateImage($data['image'], $category->image, 'categories');
        }
        foreach (['name', 'description'] as $f) {
            if (isset($data[$f])) $data[$f] = json_encode($data[$f]);
        }
        $category->update($data);
        return $category->fresh();
    }

    public function deleteCategory(Category $category): bool
    {
        $this->deleteImage($category->image);
        return $category->delete();
    }

    public function createSubCategory(array $data): SubCategory
    {
        $data['slug'] = Str::slug($data['name']['en'] ?? now()->timestamp);
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'subcategories');
        }
        $data['name'] = json_encode($data['name']);
        $data['description'] = json_encode($data['description'] ?? []);
        return SubCategory::create($data);
    }

    public function updateSubCategory(SubCategory $sub, array $data): SubCategory
    {
        if (isset($data['image'])) {
            $data['image'] = $this->updateImage($data['image'], $sub->image, 'subcategories');
        }
        foreach (['name', 'description'] as $f) {
            if (isset($data[$f])) $data[$f] = json_encode($data[$f]);
        }
        $sub->update($data);
        return $sub->fresh();
    }
}
