@extends('layouts.frontend')
@section('title', __('site.home'))

@section('content')
<!-- Hero -->
<section class="hero">
    <div class="container text-center">
        <h1>{{ __('site.hero_title') }}</h1>
        <p class="lead mb-4">{{ __('site.hero_subtitle') }}</p>
        <a href="{{ route('shop') }}" class="btn btn-light btn-lg btn-primary-custom">
            {{ __('site.shop_now') }} <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
        </a>
    </div>
</section>

<!-- Categories -->
<section class="container mb-5">
    <h2 class="text-center mb-4 fw-bold">{{ __('site.categories') }}</h2>
    <div class="row g-4">
        @foreach($categories as $cat)
        <div class="col-md-3 col-6">
            <div class="product-card text-center p-4">
                <img src="{{ $cat->image ? asset('storage/'.$cat->image) : 'https://via.placeholder.com/150' }}" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;">
                <h5>{{ $cat->name }}</h5>
                <a href="{{ route('shop', ['category' => $cat->id]) }}" class="btn btn-primary-custom btn-sm">{{ __('site.view') }}</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Featured Products -->
<section class="container mb-5">
    <h2 class="text-center mb-4 fw-bold">{{ __('site.featured') }}</h2>
    <div class="row g-4">
        @foreach($featured as $product)
        <div class="col-lg-3 col-md-4 col-6">
            @include('frontend.partials.product-card', ['product' => $product])
        </div>
        @endforeach
    </div>
</section>
@endsection
