@extends('layouts.admin')
@section('title', __('admin.create_product'))
@section('page-title', __('admin.create_product'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-plus-circle"></i> {{ __('admin.create_product') }}</h4>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- الأسماء -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_ar') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror" value="{{ old('name.ar') }}" required>
                @error('name.ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_en') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" value="{{ old('name.en') }}" required>
                @error('name.en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الوصف -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_ar') }} <span class="text-danger">*</span></label>
                <textarea name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror" rows="4" required>{{ old('description.ar') }}</textarea>
                @error('description.ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_en') }} <span class="text-danger">*</span></label>
                <textarea name="description[en]" class="form-control @error('description.en') is-invalid @enderror" rows="4" required>{{ old('description.en') }}</textarea>
                @error('description.en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- القسم والقسم الفرعي -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.category') }} <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">{{ __('admin.select_category') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sub_category') }}</label>
                <select name="sub_category_id" class="form-select">
                    <option value="">{{ __('admin.select_sub_category') }}</option>
                    @foreach($categories as $cat)
                        @foreach($cat->subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_category_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }} ({{ $cat->name }})</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <!-- SKU والسعر -->
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sku') }} <span class="text-danger">*</span></label>
                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" required>
                @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">{{ __('admin.price') }} <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sale_price') }}</label>
                <input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                <small class="text-muted">{{ __('admin.leave_empty_if_no_sale') }}</small>
            </div>

            <!-- المخزون -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.stock') }} <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الصورة الرئيسية -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.main_image') }} <span class="text-danger">*</span></label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- صور المعرض -->
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">{{ __('admin.gallery_images') }}</label>
                <input type="file" name="gallery[]" class="form-control" accept="image/*" multiple>
                <small class="text-muted">{{ __('admin.can_select_multiple') }}</small>
            </div>

            <!-- الخيارات -->
            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">{{ __('admin.featured') }}</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('admin.active') }}</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> {{ __('admin.save') }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
