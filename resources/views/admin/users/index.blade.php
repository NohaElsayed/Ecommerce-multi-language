@extends('layouts.admin')
@section('title', __('admin.users'))
@section('page-title', __('admin.users'))

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-users"></i> {{ __('admin.users') }}</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> {{ __('admin.create') }}
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.user') }}</th>
                    <th>{{ __('admin.email') }}</th>
                    <th>{{ __('admin.phone') }}</th>
                    <th>{{ __('admin.roles') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}" style="width: 40px; height: 40px; object-fit: cover;" class="rounded-circle">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                            {{ $user->status == 'active' ? __('admin.active') : __('admin.inactive') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$user->hasRole('super-admin'))
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
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
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-users" style="font-size: 3rem;"></i>
                        <p class="mt-2">{{ __('admin.no_data') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
