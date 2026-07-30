@extends('layouts.frontend')
@section('title', __('site.shop'))

@section('content')
<div class="container my-5">
    <h2 class="mb-4 fw-bold">{{ __('site.shop') }}</h2>

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar">
                <form method="GET" action="{{ route('shop') }}" id="filterForm">
                    <h5 class="filter-title"><i class="fas fa-filter"></i> {{ __('site.filter') }}</h5>

                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.search') }}</label>
                        <input type="text" name="search" class="form-control"
                               value="{{ request('search') }}"
                               placeholder="{{ __('site.search_placeholder') }}">
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.category') }}</label>
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">{{ __('site.all') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sub Category -->
                    @if(request('category'))
                        @php $cat = \App\Models\Category::find(request('category')); @endphp
                        @if($cat && $cat->subCategories->count())
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('site.sub_category') }}</label>
                            <select name="sub_category" class="form-select" onchange="this.form.submit()">
                                <option value="">{{ __('site.all') }}</option>
                                @foreach($cat->subCategories as $sub)
                                    <option value="{{ $sub->id }}" {{ request('sub_category') == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    @endif

                    <!-- Price Range -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.price_range') }}</label>
                        <div class="d-flex gap-2">
                            <input type="number" name="min_price" class="form-control"
                                   placeholder="Min" value="{{ request('min_price') }}">
                            <input type="number" name="max_price" class="form-control"
                                   placeholder="Max" value="{{ request('max_price') }}">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('site.sort') }}</label>
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">{{ __('site.default') }}</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                {{ __('site.price_low_high') }}
                            </option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                {{ __('site.price_high_low') }}
                            </option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                {{ __('site.newest') }}
                            </option>
                        </select>
                    </div>

                    <!-- Featured -->
                    <div class="form-check mb-3">
                        <input type="checkbox" name="featured" value="1" class="form-check-input"
                               id="featured" {{ request('featured') ? 'checked' : '' }}
                               onchange="this.form.submit()">
                        <label class="form-check-label" for="featured">
                            {{ __('site.featured_only') }}
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="fas fa-search"></i> {{ __('site.apply') }}
                    </button>
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2">
                        {{ __('site.reset') }}
                    </a>
                </form>
            </div>
        </div>

        <!-- Products -->
        <div class="col-lg-9">
            <!-- Results Count -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="text-muted mb-0">
                    <i class="fas fa-box-open"></i>
                    {{ __('site.showing') }}
                    <strong>{{ $products->firstItem() ?? 0 }}</strong>
                    {{ __('site.to') }}
                    <strong>{{ $products->lastItem() ?? 0 }}</strong>
                    {{ __('site.of') }}
                    <strong>{{ $products->total() }}</strong>
                    {{ __('site.results') }}
                </p>
                <div class="d-flex align-items-center gap-2">
                    <label class="text-muted mb-0">{{ __('site.per_page') }}:</label>
                    <select class="form-select form-select-sm" style="width: auto;"
                            onchange="window.location.href = '{{ route('shop') }}?per_page=' + this.value">
                        <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                        <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                        <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36</option>
                        <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                <div class="col-md-4 col-6">
                    @include('frontend.partials.product-card', ['product' => $product])
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-search" style="font-size: 3rem; color: #ddd;"></i>
                        <h4 class="mt-3">{{ __('site.no_products') }}</h4>
                        <p>{{ __('site.no_products_desc') }}</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary-custom mt-3">
                            <i class="fas fa-redo"></i> {{ __('site.reset') }}
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- ✅ Pagination محسّنة -->
            @if($products->hasPages())
            <div class="mt-5">
                <nav aria-label="Page navigation">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// ✅ الحفاظ على الفلاتر عند التنقل بين الصفحات
document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.classList.add('btn', 'btn-outline-primary', 'mx-1');
    });
});
</script>
@endpush
@endsection
