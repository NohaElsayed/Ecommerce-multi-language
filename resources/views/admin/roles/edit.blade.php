@extends('layouts.admin')
@section('title', __('admin.edit_role'))
@section('page-title', __('admin.edit_role'))

@section('content')
<div class="card-custom">
    <h4 class="mb-4"><i class="fas fa-user-edit"></i> {{ __('admin.edit_role') }}</h4>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label fw-bold">{{ __('admin.role_name') }} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
            </div>
        </div>

        <h5 class="mb-3">{{ __('admin.permissions') }}</h5>
        <div class="row">
            @foreach($permissions as $module => $perms)
                <div class="col-md-4 mb-3">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <strong>{{ ucfirst($module) }}</strong>
                        </div>
                        <div class="card-body">
                            @foreach($perms as $perm)
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="permissions[]" class="form-check-input" id="perm_{{ $perm->id }}" value="{{ $perm->name }}" {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $perm->id }}">
                                        {{ $perm->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-save"></i> {{ __('admin.update') }}
            </button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
