<div class="product-card position-relative">
    @if($product->sale_price)
        <span class="badge-sale">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
    @endif
    <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300x250' }}" class="product-img" alt="{{ $product->name }}">
    <div class="product-body">
        <small class="text-muted">{{ $product->category->name ?? '' }}</small>
        <h5 class="product-title">{{ $product->name }}</h5>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="product-price">{{ number_format($product->final_price, 2) }} {{ __('site.currency') }}</span>
                @if($product->sale_price)
                    <span class="old-price">{{ number_format($product->price, 2) }}</span>
                @endif
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                <i class="fas fa-eye"></i>
            </a>
            <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="btn btn-primary-custom btn-sm w-100">
                    <i class="fas fa-cart-plus"></i>
                </button>
            </form>
        </div>
    </div>
</div>
