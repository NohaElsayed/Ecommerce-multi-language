<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    /**
     * عرض جميع المنتجات
     */
    public function index(Request $request)
    {
        $products = $this->productService->getAll($request->all());
        return view('admin.products.index', compact('products'));
    }

    /**
     * عرض نموذج إنشاء منتج
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * ✅ حفظ منتج جديد
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'description.en' => 'required',
            'description.ar' => 'required',
            'short_description.en' => 'nullable|string',
            'short_description.ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // تحويل الـ booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        // ✅ استدعاء دالة create من الـ Service
        $this->productService->create($data);

        return redirect()->route('admin.products.index')
            ->with('success', __('admin.created'));
    }

    /**
     * عرض نموذج تعديل منتج
     */
    public function edit($id)
    {
        $product = $this->productService->find($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }
        $categories = $this->categoryService->getAllCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * ✅ تحديث منتج
     */
    public function update(Request $request, $id)
    {
        $product = $this->productService->find($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }

        $data = $request->validate([
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'description.en' => 'required',
            'description.ar' => 'required',
            'short_description.en' => 'nullable|string',
            'short_description.ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        // ✅ استدعاء دالة update من الـ Service
        $this->productService->update($product, $data);

        return redirect()->route('admin.products.index')
            ->with('success', __('admin.updated'));
    }

    /**
     * ✅ حذف منتج
     */
    public function destroy($id)
    {
        $product = $this->productService->find($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found');
        }

        $this->productService->delete($product);

        return redirect()->route('admin.products.index')
            ->with('success', __('admin.deleted'));
    }
}
