@extends('layouts.admin')
@section('title', __('admin.edit_category'))
@section('page-title', __('admin.edit_category'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-edit"></i> {{ __('admin.edit_category') }}</h4>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_ar') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror" value="{{ old('name.ar', $category->getAllTranslations('name')['ar'] ?? '') }}" required>
                @error('name.ar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_en') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[en]" class="form-control @error('name.en') is-invalid @enderror" value="{{ old('name.en', $category->getAllTranslations('name')['en'] ?? '') }}" required>
                @error('name.en')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_ar') }}</label>
                <textarea name="description[ar]" class="form-control" rows="3">{{ old('description.ar', $category->getAllTranslations('description')['ar'] ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.description_en') }}</label>
                <textarea name="description[en]" class="form-control" rows="3">{{ old('description.en', $category->getAllTranslations('description')['en'] ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.image') }}</label>
                @if($category->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" style="max-height: 100px;" class="rounded">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">{{ __('admin.leave_empty_to_keep') }}</small>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.sort_order') }}</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('admin.active') }}</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> {{ __('admin.update') }}
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
