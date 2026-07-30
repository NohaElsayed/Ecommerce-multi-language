@extends('layouts.admin')
@section('title', __('admin.edit_sub_category'))
@section('page-title', __('admin.edit_sub_category'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-edit"></i> {{ __('admin.edit_sub_category') }}</h4>

    <form action="{{ route('admin.sub-categories.update', $subCategory) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.category') }} <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $subCategory->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_ar') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar', $subCategory->getAllTranslations('name')['ar'] ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name_en') }} <span class="text-danger">*</span></label>
                <input type="text" name="name[en]" class="form-control" value="{{ old('name.en', $subCategory->getAllTranslations('name')['en'] ?? '') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.image') }}</label>
                @if($subCategory->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$subCategory->image) }}" style="max-height: 100px;" class="rounded">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $subCategory->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ __('admin.active') }}</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> {{ __('admin.update') }}
            </button>
            <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
