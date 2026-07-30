@extends('layouts.admin')
@section('title', __('admin.roles'))
@section('page-title', __('admin.roles'))

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-user-shield"></i> {{ __('admin.roles') }}</h4>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> {{ __('admin.create') }}
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.role_name') }}</th>
                    <th>{{ __('admin.permissions') }}</th>
                    <th>{{ __('admin.users_count') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>
                        <strong>{{ $role->name }}</strong>
                        @if($role->name == 'super-admin')
                            <span class="badge bg-danger ms-2">{{ __('admin.super_admin') }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $role->permissions->count() }} {{ __('admin.permissions') }}</span>
                    </td>
                    <td>
                        <span class="badge bg-primary">{{ $role->users_count }}</span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!in_array($role->name, ['super-admin', 'admin']))
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-user-shield" style="font-size: 3rem;"></i>
                        <p class="mt-2">{{ __('admin.no_data') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
