@extends('layouts.frontend')
@section('title', $product->name)

@section('content')
    <div class="container my-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">{{ __('site.shop') }}</a></li>
                @if ($product->category)
                    <li class="breadcrumb-item">
                        <a
                            href="{{ route('shop', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="row">
            <!-- Product Images -->
            <!-- Product Images -->
            <div class="col-lg-6 mb-4">
                <div class="card-custom p-3 text-center">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x600' }}"
                        class="img-fluid rounded main-product-img" alt="{{ $product->name }}"
                        style="max-height: 500px; object-fit: contain; width: 100%;">

                    @php
                        // ✅ التحقق الآمن من gallery
                        $gallery = is_array($product->gallery)
                            ? $product->gallery
                            : (is_string($product->gallery)
                                ? json_decode($product->gallery, true)
                                : []);
                    @endphp

                    @if (!empty($gallery))
                        <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x600' }}"
                                class="rounded border border-2 border-primary"
                                style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                                onclick="changeImage(this.src, this)">
                            @foreach ($gallery as $img)
                                @if ($img)
                                    <img src="{{ asset('storage/' . $img) }}" class="rounded border"
                                        style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                                        onclick="changeImage(this.src, this)">
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="card-custom p-4 h-100">
                    @if ($product->category)
                        <span class="badge bg-primary mb-2">{{ $product->category->name }}</span>
                    @endif

                    <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-muted">{{ __('site.sku') }}: <strong>{{ $product->sku }}</strong></span>
                        @if ($product->stock > 0)
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i>
                                {{ __('site.in_stock') }}</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-times-circle"></i>
                                {{ __('site.out_of_stock') }}</span>
                        @endif
                    </div>

                    <div class="mb-4">
                        @if ($product->sale_price)
                            <h3 class="text-primary fw-bold mb-0">
                                {{ number_format($product->sale_price, 2) }} {{ __('site.currency') }}
                            </h3>
                            <span class="text-muted text-decoration-line-through fs-5">
                                {{ number_format($product->price, 2) }} {{ __('site.currency') }}
                            </span>
                            <span class="badge bg-danger ms-2">
                                -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                            </span>
                        @else
                            <h3 class="text-primary fw-bold mb-0">
                                {{ number_format($product->price, 2) }} {{ __('site.currency') }}
                            </h3>
                        @endif
                    </div>

                    @if ($product->short_description)
                        <p class="text-muted mb-4">{{ $product->short_description }}</p>
                    @endif

                    <!-- Add to Cart Form -->
                    @if ($product->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="d-flex align-items-center gap-3 mb-4">
                                <label class="fw-bold mb-0">{{ __('site.quantity') }}:</label>
                                <div class="input-group" style="max-width: 150px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="updateQty(-1)">-</button>
                                    <input type="number" name="quantity" id="qty" value="1" min="1"
                                        max="{{ $product->stock }}" class="form-control text-center" required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="updateQty(1)">+</button>
                                </div>
                                <span class="text-muted small">({{ $product->stock }} {{ __('site.available') }})</span>
                            </div>

                            <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                                <i class="fas fa-cart-plus"></i> {{ __('site.add_to_cart') }}
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg w-100" disabled>
                            <i class="fas fa-times-circle"></i> {{ __('site.out_of_stock') }}
                        </button>
                    @endif

                    <!-- Meta Info -->
                    <div class="mt-4 pt-4 border-top">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-truck text-primary"></i>
                            <span>{{ __('site.free_shipping') }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-shield-alt text-primary"></i>
                            <span>{{ __('site.secure_payment') }}</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-undo text-primary"></i>
                            <span>{{ __('site.easy_returns') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description Tab -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card-custom p-4">
                    <h4 class="fw-bold mb-3 border-bottom pb-2">{{ __('site.description') }}</h4>
                    <div class="text-muted" style="line-height: 1.8;">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if (isset($related) && $related->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="fw-bold mb-4 border-bottom pb-2">{{ __('site.related_products') }}</h4>
                    <div class="row g-4">
                        @foreach ($related as $relProduct)
                            <div class="col-lg-3 col-md-4 col-6">
                                @include('frontend.partials.product-card', ['product' => $relProduct])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function changeImage(src, element) {
                document.querySelector('.main-product-img').src = src;
                // إزالة الحدود من جميع الصور
                document.querySelectorAll('.d-flex.justify-content-center img').forEach(img => {
                    img.classList.remove('border-primary');
                    img.classList.add('border');
                });
                // إضافة حدود للصورة المحددة
                element.classList.remove('border');
                element.classList.add('border-primary');
            }

            function updateQty(change) {
                const qtyInput = document.getElementById('qty');
                let newValue = parseInt(qtyInput.value) + change;
                const max = parseInt(qtyInput.max);
                const min = parseInt(qtyInput.min);

                if (newValue >= min && newValue <= max) {
                    qtyInput.value = newValue;
                }
            }
        </script>
    @endpush
@endsection
