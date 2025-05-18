@extends('themes.zenblog.layouts.main')
@section('main')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Rencana Pembelajaran Semester</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">HOME</a></li>
                    <li class="current">RPS </li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        <div class="row">

            <div class="col-lg-8 px-0">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <div class="container ">

                        <article class="article">

                            <p class="mb-3">{!! $rps->deskripsi !!}</p>
                            <iframe id="jadwal-iframe" src="{{ asset('storage/' . $rps->file) }}" width="100%"
                                height="650px" style="border: none; margin-top: 20px;">
                            </iframe>

                            {{-- <div class="content">
                                {!! $page->content !!}

                            </div><!-- End post content --> --}}

                        </article>

                    </div>
                </section><!-- /Blog Details Section -->


            </div>

            @include('themes.zenblog.layouts.sidebar')

        </div>
    </div>

</main>
@endsection