@extends('themes.simple-blog.layouts.main')

@push('head')
<!-- SEO Meta Tags -->
<meta name="title" content="{{ $page->title }}">
<meta name="description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
<meta name="keywords" content="{{ implode(',', $page->tags ?? ['blog', 'post']) }}">
<meta name="author" content="{{ $page->author ?? 'Admin' }}">
<meta name="robots" content="index, follow">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $page->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
<meta property="og:image" content="{{ $page->image }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="Your Website Name">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->title }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
<meta name="twitter:image" content="{{ $page->image }}">
@endpush

@push('styles')
<style>
    .page-title a {
        color: #333 !important;
        text-decoration: none !important;
    }

    .page-title a:hover {
        color: #000 !important;
        text-decoration: underline;
    }
</style>
@endpush

@section('main')

<!-- Page Title -->
<div class="page-title py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="my-2 my-lg-0">{{ $page->title }}</h1>
        <nav class="breadcrumbs" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $page->title }}
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <section id="blog-details" class="blog-details section mb-5">
                <article class="article">
                    @if($page->image)
                    <img src="{{ $page->image }}" alt="{{ $page->title }}" class="img-fluid mb-4">
                    @endif

                    <div class="content">
                        {!! $page->content !!}
                    </div>

                </article>

            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('themes.simple-blog.layouts.sidebar')
        </div>
    </div>
</div>
@endsection