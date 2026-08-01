@extends('layouts.admin')
@section('title', __('admin.create_user'))
@section('page-title', __('admin.create_user'))

@section('content')
    <div class="card-custom">
        <h4 class="mb-4"><i class="fas fa-user-plus"></i> {{ __('admin.create_user') }}</h4>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('admin.name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('admin.email') }} <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('admin.phone') }}</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('admin.password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> {{ __('auth.confirm_password') }}
                    </label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="{{ __('auth.confirm_password_placeholder') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('admin.avatar') }}</label>
                    <input type="file" name="avatar" class="form-control" accept="image/*">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">{{ __('admin.roles') }}</label>
                    <select name="roles[]" class="form-select" multiple>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>{{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">{{ __('admin.hold_ctrl_to_select_multiple') }}</small>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="status" class="form-check-input" id="status" value="active"
                            {{ old('status', 'active') == 'active' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">{{ __('admin.active') }}</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom">
                    <i class="fas fa-save"></i> {{ __('admin.save') }}
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> {{ __('admin.cancel') }}
                </a>
            </div>
        </form>
    </div>
@endsection
