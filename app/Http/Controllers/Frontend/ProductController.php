<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller {
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function index() {
        $filters = request()->only(['category', 'sub_category', 'min_price', 'max_price', 'search', 'sort']);
        $products = $this->productService->getFilteredProducts($filters);
        $categories = Category::with('subCategories')->active()->get();
        return view('frontend.products.index', compact('products', 'categories', 'filters'));
    }

    public function show(Product $product) {
        $product->load(['category', 'subCategory', 'images']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->limit(4)
            ->get();
        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
