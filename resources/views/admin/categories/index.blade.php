@extends('layouts.admin')
@section('title', __('admin.categories'))
@section('page-title', __('admin.categories'))

@section('content')
<div class="card-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-folder"></i> {{ __('admin.categories') }}</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary-custom">
            <i class="fas fa-plus"></i> {{ __('admin.create') }}
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.image') }}</th>
                    <th>{{ __('admin.name') }}</th>
                    <th>{{ __('admin.sub_categories') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        @if($category->image)
                            <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>
                        <span class="badge bg-info">{{ $category->subCategories->count() }}</span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                            {{ $category->is_active ? __('admin.active') : __('admin.inactive') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.confirm_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-folder-open" style="font-size: 3rem;"></i>
                        <p class="mt-2">{{ __('admin.no_data') }}</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
