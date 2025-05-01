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

    .card-img-top img {
        width: 100%;
        /* Gambar mengikuti lebar penuh dari container */
        height: 250px;
        /* Atur tinggi sesuai kebutuhan */
        object-fit: cover;
        /* Pastikan gambar tetap proporsional dan memenuhi container */
        display: block;
        /* Menghilangkan spasi bawah bawaan gambar */
    }
</style>
@endpush

@section('main')

<!-- Konten Utama -->
<div class="container">


    <!-- Page Title -->
    <div class="page-title py-3">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="my-2 my-lg-0">Galeri</h1>
            <nav class="breadcrumbs" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Galeri
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <hr class="my-3" style="border-top: 3px solid #2a2a2a;">


    <div class="container aos-init aos-animate mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
            @foreach ($galleries as $item)
            <div class="col-lg-4">
                <div class="card my-3">
                    <a href="{{ route('gallery.detail', $item->slug) }}">
                        <img class="card-img-top img-fluid" src="{{ $item->image }}" alt="{{ $item->name }}" />
                    </a>
                    <div class="card-body">
                        <div class="small text-muted">{{ $item->created_at->format('M Y') }}</div>
                        <h2 class="card-title h5">
                            <a href="{{ route('gallery.detail', $item->slug) }}">
                                {{ $item->name }}
                            </a>
                        </h2>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection