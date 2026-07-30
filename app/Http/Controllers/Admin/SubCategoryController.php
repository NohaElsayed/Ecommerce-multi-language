<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    /**
     * عرض جميع الأقسام الفرعية
     */
    public function index()
    {
        $subCategories = SubCategory::with('category')->latest()->get();
        return view('admin.sub-categories.index', compact('subCategories'));
    }

    /**
     * عرض نموذج إنشاء قسم فرعي
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-categories.create', compact('categories'));
    }

    /**
     * حفظ قسم فرعي جديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'description.ar' => 'nullable|string',
            'description.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $this->categoryService->createSubCategory($data);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', __('admin.created'));
    }

    /**
     * عرض نموذج تعديل قسم فرعي
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::all();
        return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
    }

    /**
     * تحديث قسم فرعي
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'description.ar' => 'nullable|string',
            'description.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $this->categoryService->updateSubCategory($subCategory, $data);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', __('admin.updated'));
    }

    /**
     * حذف قسم فرعي
     */
    public function destroy(SubCategory $subCategory)
    {
        // حذف الصورة إذا وجدت
        if ($subCategory->image) {
            $this->categoryService->deleteImage($subCategory->image);
        }

        $subCategory->delete();

        return redirect()->route('admin.sub-categories.index')
            ->with('success', __('admin.deleted'));
    }
}
