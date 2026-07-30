@extends('layouts.admin')
@section('title', __('admin.create_category'))
@section('page-title', __('admin.create_category'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-plus-circle"></i> {{ __('admin.create_category') }}</h4>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- الاسم بالعربي -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_ar') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror" value="{{ old('name.ar') }}" required>
                @error('name.ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الاسم بالإنجليزي -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_en') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" value="{{ old('name.en') }}" required>
                @error('name.en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الوصف بالعربي -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_ar') }}</label>
                <textarea name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror" rows="3">{{ old('description.ar') }}</textarea>
                @error('description.ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الوصف بالإنجليزي -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_en') }}</label>
                <textarea name="description[en]" class="form-control @error('description.en') is-invalid @enderror" rows="3">{{ old('description.en') }}</textarea>
                @error('description.en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الصورة -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.image') }}</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- الترتيب -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sort_order') }}</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>

            <!-- الحالة -->
            <div class="col-md-12 mb-3">
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
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
