@extends('backend.layouts.main', ['title' => 'Edit Data Dosen'])

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="page-header">
                <h3 class="fw-bold mb-3 fs-3">Edit Data Dosen</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="{{ route('dosen.index') }}">Daftar Dosen</a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><span>Edit Data Dosen</span></li>
                </ul>
            </div>
        </div>

        <form method="POST" action="{{ route('dosen.update', $dosen->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $dosen->nama) }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP / NIDN</label>
                                <input type="text" name="nip" id="nip"
                                    class="form-control @error('nip') is-invalid @enderror"
                                    value="{{ old('nip', $dosen->nip) }}" required>
                                @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan"
                                    class="form-control @error('jabatan') is-invalid @enderror"
                                    value="{{ old('jabatan', $dosen->jabatan) }}" required>
                                @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <a href="{{ route('dosen.index') }}" class="btn btn-dark">Kembali</a>
                            <button type="submit" class="btn btn-success">Ubah Data</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    {{-- Foto --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Dosen</label>
                                <input type="file" name="foto" id="foto" accept="image/*"
                                    class="form-control @error('foto') is-invalid @enderror">
                                @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview Gambar -->
                            <div class="mb-3">
                                <img id="imagePreview" src="{{ $dosen->foto ? asset('storage/' . $dosen->foto) : '#' }}"
                                    alt="Foto {{ $dosen->nama }}"
                                    style="max-width: 100%; height: auto; {{ $dosen->foto ? '' : 'display: none;' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview Gambar
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection