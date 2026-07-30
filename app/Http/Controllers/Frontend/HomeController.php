<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\CategoryService;

class HomeController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService
    ) {}

    public function index()
    {
        // ✅ استخدام الدوال الصحيحة
        $featured = $this->productService->getFeaturedProducts(8);
        $newArrivals = $this->productService->getNewArrivals(8);
        $categories = $this->categoryService->getAllCategories();

        return view('frontend.home', compact('featured', 'newArrivals', 'categories'));
    }
}
