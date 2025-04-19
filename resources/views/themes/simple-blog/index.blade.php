@extends('themes.simple-blog.layouts.main')

@push('styles')
<style>
    /* Title dalam carousel */
    .carousel-caption h5 a {
        color: #ffffff !important;
        /* ubah sesuai warna yang diinginkan */
        text-decoration: none !important;
    }

    /* Title berita (card) */
    .card-title a {
        color: #333 !important;
        /* ubah warna sesuai keinginan */
        text-decoration: none !important;
    }

    .card-title a:hover {
        color: #000 !important;
        /* opsional: warna saat hover */
        text-decoration: underline;
        /* atau none jika tidak ingin underline saat hover */
    }
</style>
@endpush

@section('main')
<!-- Header dengan carousel -->
<header class="py-2 bg-light border-bottom mb-4">
    <div class="container">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($banner as $index => $post)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}"
                    class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($banner as $index => $post)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ $post->image }}" class="d-block img-fluid mx-auto" alt="{{ $post->title }}"
                        style="max-height: 400px; object-fit: cover; width: 100%;">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                        <h5>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-white text-decoration-none">
                                {{ Str::limit($post->title, 60, '...') }}
                            </a>
                        </h5>
                        <p>{{ Str::limit($post->excerpt, 150, '...') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</header>

<!-- Konten Utama -->
<div class="container">

    {{-- Section Component --}}
    @php
    $sections = [
    ['title' => 'Berita Utama', 'data' => $beritaUtama->take(4)],
    ['title' => 'Berita Terbaru', 'data' => $posts->take(8)],
    ['title' => 'Pengumuman', 'data' => $pengumumanPosts->take(4)],
    ];
    @endphp

    @foreach ($sections as $section)
    <div class="container aos-init aos-animate mb-3" data-aos="fade-up">
        <div class="d-flex align-items-center justify-content-center">
            <h2>{{ $section['title'] }}</h2>
        </div>
    </div>
    <hr class="my-3" style="border-top: 3px solid #2a2a2a;">

    <div class="container aos-init aos-animate mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            @foreach ($section['data'] as $post)
            <div class="col-lg-3">
                <div class="card my-3">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <img class="card-img-top img-fluid" src="{{ $post->image }}" alt="{{ $post->title }}" />
                    </a>
                    <div class="card-body">
                        <div class="small text-muted">{{ $post->created_at->format('d M Y') }}</div>
                        <h2 class="card-title h5">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                {{ Str::limit($post->title, 25, '...') }}
                            </a>
                        </h2>
                        <p class="card-text">{{ Str::limit($post->excerpt, 50, '...') }}</p>
                        <a class="btn btn-primary" href="{{ route('posts.show', $post->slug) }}">
                            Baca Selengkapnya →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('allPosts') }}" class="btn btn-outline-primary">Selengkapnya</a>
    </div>
    @endforeach

</div>
@endsection