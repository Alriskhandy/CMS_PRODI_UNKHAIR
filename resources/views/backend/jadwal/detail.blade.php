@extends('backend.layouts.main', ['title' => 'Jadwal Perkuliahan'])

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2">
            <div class="page-header">
                <h3 class="fw-bold fs-3">Jadwal Perkuliahan {{ $jadwal->tahun_ajaran }}</h3>
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
                        <a href="{{ route('jadwal.index') }}">Jadwal Perkuliahan</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Detail</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ms-md-auto mb-3 py-md-0">
            <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary btn-round me-2">
                Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <iframe src="{{ asset('storage/' . $jadwal->file) }}" width="100%" height="650px"
                            style="border: none;">
                        </iframe>
                    </div>
                </div>
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