@extends('themes.zenblog.layouts.main')
@section('main')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Jadwal Perkuliahan</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">HOME</a></li>
                    <li class="current">JADWAL</li>
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

                            <div class="row">
                                <div class="col-lg-6 col-md-8">

                                    <select class="form-select form-select-sm" id="jadwal-select">
                                        <option selected disabled>Pilih Tahun Ajaran</option>
                                        @foreach ($jadwal as $j)
                                        <option value="{{ asset('storage/' . $j->file) }}">{{ $j->tahun_ajaran }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <iframe id="jadwal-iframe" src="" width="100%" height="600px"
                                style="border: none; margin-top: 20px;">
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
<script>
    document.getElementById('jadwal-select').addEventListener('change', function () {
        var selectedFile = this.value;
        document.getElementById('jadwal-iframe').src = selectedFile;
    });
</script>
@endsection