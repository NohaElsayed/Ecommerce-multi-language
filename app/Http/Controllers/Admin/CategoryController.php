<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'description.ar' => 'nullable|string',
            'description.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $this->categoryService->createCategory($data);

        return redirect()->route('admin.categories.index')->with('success', __('admin.created'));
    }

    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $data = $request->validate([
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'description.ar' => 'nullable|string',
            'description.en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $this->categoryService->updateCategory($category, $data);

        return redirect()->route('admin.categories.index')->with('success', __('admin.updated'));
    }

    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $this->categoryService->deleteCategory($category);

        return redirect()->route('admin.categories.index')->with('success', __('admin.deleted'));
    }
}
