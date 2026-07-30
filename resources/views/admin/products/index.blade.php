@extends('layouts.admin')
@section('title', __('admin.products'))
@section('page-title', __('admin.products'))

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-box"></i> {{ __('admin.products') }}</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> {{ __('admin.create') }}
        </a>
    </div>

    <!-- فلترة سريعة -->
    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="{{ __('admin.search') }}" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">{{ __('admin.all_categories') }}</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">{{ __('admin.all_statuses') }}</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('admin.active') }}</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('admin.inactive') }}</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary-custom w-100">
                <i class="fas fa-filter"></i> {{ __('admin.filter') }}
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.image') }}</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.category') }}</th>
                    <th>{{ __('admin.price') }}</th>
                    <th>{{ __('admin.stock') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark ms-1"><i class="fas fa-star"></i></span>
                        @endif
                        <br>
                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $product->category->name ?? '-' }}</span>
                    </td>
                    <td>
                        @if($product->sale_price)
                            <strong class="text-danger">{{ number_format($product->sale_price, 2) }}</strong>
                            <br>
                            <small class="text-muted text-decoration-line-through">{{ number_format($product->price, 2) }}</small>
                        @else
                            <strong>{{ number_format($product->price, 2) }}</strong>
                        @endif
                    </td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? __('admin.active') : __('admin.inactive') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-box-open" style="font-size: 3rem;"></i>
                        <p class="mt-2">{{ __('admin.no_data') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="mt-4">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
