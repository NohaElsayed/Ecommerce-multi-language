<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        // ✅ استخدام withQueryString للحفاظ على الفلاتر
        $products = $this->productService->getAll($request->all(), 12);
        $categories = $this->categoryService->getAllCategories();

        return view('frontend.shop', compact('products', 'categories', 'request'));
    }

    public function show($slug)
    {
        $product = \App\Models\Product::where('slug', $slug)
            ->with(['category', 'subCategory'])
            ->firstOrFail();

        $related = $this->productService->getRelatedProducts($product, 4);

        return view('frontend.product', compact('product', 'related'));
    }
}
