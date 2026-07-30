@extends('layouts.admin')
@section('title', __('admin.edit_user'))
@section('page-title', __('admin.edit_user'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-user-edit"></i> {{ __('admin.edit_user') }}</h4>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.email') }} <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.phone') }}</label>
                <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.password') }}</label>
                <input type="password" name="password" class="form-control">
                <small class="text-muted">{{ __('admin.leave_empty_to_keep_current') }}</small>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.avatar') }}</label>
                @if($user->avatar)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$user->avatar) }}" style="max-height: 80px;" class="rounded-circle">
                    </div>
                @endif
                <input type="file" name="avatar" class="form-control" accept="image/*">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">{{ __('admin.roles') }}</label>
                <select name="roles[]" class="form-select" multiple>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-check form-switch">
                    <input type="checkbox" name="status" class="form-check-input" id="status" value="active" {{ old('status', $user->status) == 'active' ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ __('admin.active') }}</label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> {{ __('admin.update') }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
