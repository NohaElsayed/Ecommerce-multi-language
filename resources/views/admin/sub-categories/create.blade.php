@extends('layouts.admin')
@section('title', __('admin.create_sub_category'))
@section('page-title', __('admin.create_sub_category'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-plus-circle"></i> {{ __('admin.create_sub_category') }}</h4>

    <form action="{{ route('admin.sub-categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
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

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.image') }}</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

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
            <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
