@extends('themes.zenblog.layouts.main')
@section('main')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Daftar Dosen</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">HOME</a></li>
                    <li class="current">DAFTAR DOSEN</li>
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
                            <table id="basic-datatables" class="display table  table-hover border">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Foto</th>
                                        <th>Nama Dosen</th>
                                        <th>NIP / NIDN</th>
                                        <th>Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dosen as $d)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>

                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $d->foto) }}" alt="Foto {{ $d->nama }}"
                                                class="img-thumbnail rounded-circle d-block mx-auto"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </td>

                                        <td>{{ $d->nama }}</td>
                                        <td>
                                            @if(!empty($d->nip))
                                            {{ $d->nip }} / {{ $d->nidn }}
                                            @else
                                            {{ $d->nidn }}
                                            @endif
                                        </td>

                                        <td>{{ $d->jabatan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

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