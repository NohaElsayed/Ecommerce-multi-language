@extends('layouts.admin')
@section('title', __('admin.edit_product'))
@section('page-title', __('admin.edit_product'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-edit"></i> {{ __('admin.edit_product') }}</h4>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_ar') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar', $product->getAllTranslations('name')['ar'] ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_en') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[en]" class="form-control" value="{{ old('name.en', $product->getAllTranslations('name')['en'] ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_ar') }} <span class="text-danger">*</span></label>
                <textarea name="description[ar]" class="form-control" rows="4" required>{{ old('description.ar', $product->getAllTranslations('description')['ar'] ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_en') }} <span class="text-danger">*</span></label>
                <textarea name="description[en]" class="form-control" rows="4" required>{{ old('description.en', $product->getAllTranslations('description')['en'] ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.category') }} <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sub_category') }}</label>
                <select name="sub_category_id" class="form-select">
                    <option value="">{{ __('admin.select_sub_category') }}</option>
                    @foreach($categories as $cat)
                        @foreach($cat->subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_category_id', $product->sub_category_id) == $sub->id ? 'selected' : '' }}>{{ $sub->name }} ({{ $cat->name }})</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sku') }} <span class="text-danger">*</span></label>
                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">{{ __('admin.price') }} <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sale_price') }}</label>
                <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.stock') }} <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.main_image') }}</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$product->image) }}" style="max-height: 100px;" class="rounded">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">{{ __('admin.leave_empty_to_keep') }}</small>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">{{ __('admin.gallery_images') }}</label>
                @if($product->gallery && is_array($product->gallery))
                    <div class="d-flex gap-2 mb-2 flex-wrap">
                        @foreach($product->gallery as $img)
                            <img src="{{ asset('storage/'.$img) }}" style="width: 80px; height: 80px; object-fit: cover;" class="rounded border">
                        @endforeach
                    </div>
                @endif
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">{{ __('admin.new_images_will_replace_old') }}</small>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">{{ __('admin.featured') }}</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('admin.active') }}</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> {{ __('admin.update') }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
