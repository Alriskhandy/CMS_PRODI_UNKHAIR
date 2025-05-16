@extends('backend.layouts.main', ['title' => 'Pengguna'])

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
            <div class="page-header">
                <h3 class="fw-bold fs-3">Pengguna</h3>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Pengguna</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-lg-6 mx-auto">
                {{-- Card: Header with Search --}}
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Pengguna (<span class="text-danger">{{ $count }}</span>)</h4>
                        <form class="d-flex d-none d-lg-flex" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari pengguna..." readonly>
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Card: Daftar Pengguna --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Pengguna</h5>
                        <button class="btn btn-label-info btn-sm rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="fa fa-envelope me-1"></i> Undang Pengguna
                        </button>
                    </div>

                    <!-- Modal Undang Pengguna -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Undang Pengguna Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-exit"></i>
                                    </button>
                                </div>
                                <form action="{{ route('pengguna.undang') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="role_id" class="form-label">Peran</label>
                                            <select name="role_id" id="role_id" class="form-control" required>
                                                <option value="" disabled selected>-- Pilih Peran --</option>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id')==$role->id
                                                    ? 'selected' : '' }}>
                                                    {{ $role->nama_role }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input class="form-control" type="email" id="email" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">Pesan
                                                (Opsional)</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-outline-secondary btn-round"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-outline-success btn-round">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @forelse ($users as $user)
                        <div class="card px-3 mb-1 border-light shadow-sm">
                            <div class="card-body d-flex align-items-center">

                                <img src="{{ asset('backend/assets/img/profile-logo.png') }}" alt="Foto Profil"
                                    class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">

                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">{{ $user->name }}</h6>
                                    <small class="text-muted">{{ $user->email }}</small><br>
                                    @if ($user->role_id == 1)
                                    <span class="badge bg-warning mt-1">{{ $user->role->nama_role }}</span>
                                    @else
                                    <span class="badge bg-info mt-1">{{ $user->role->nama_role }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted">Belum ada pengguna.</p>
                        @endforelse
                    </div>
                </div>

                @if ($invites != null)
                {{-- Card: Daftar Undangan--}}
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Undangan yang belum diterima</h5>
                    </div>

                    <div class="card-body">
                        <div class="card px-3 mb-1 border-light shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                @foreach ($invites as $invited)
                                <img src="{{ asset('backend/assets/img/profile-logo.png') }}" alt="Foto Profil"
                                    class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="me-3">
                                    <h6 class="mb-1 fs-5 fw-semibold">{{ $invited->email }}</h6>
                                    @if ($invited->role_id == 1)
                                    <span class="badge bg-warning mt-1">{{ $invited->role->nama_role }}</span>
                                    @else
                                    <span class="badge bg-info mt-1">{{ $invited->role->nama_role }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('pengguna.email', $invited->email) }}"
                                    class="btn btn-label-success btn-sm rounded-pill">
                                    <i class="fa fa-envelope me-1"></i> Kirim Ulang Email
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify.js/0.4.2/notify.min.js"></script>
<script>
    function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#db1b14',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function copyComment(content) {
            navigator.clipboard.writeText(content).then(function() {
                alert("Komentar telah disalin ke clipboard!");
            }, function(err) {
                alert("Gagal menyalin komentar: ", err);
            });
        }
</script>
@endpush