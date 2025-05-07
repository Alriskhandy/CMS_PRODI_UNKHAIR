@extends('backend.layouts.main', ['title' => 'Jadwal Perkuliahan'])

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="page-header">
                <h3 class="fw-bold mb-3 fs-3">Semua Jadwal</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Jadwal Perkuliahan</a>
                    </li>
                </ul>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <!-- Button trigger modal -->
                <button class="btn btn-label-info btn-round me-2" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop">
                    <i class="fa fa-plus"></i> Tambah Jadwal
                </button>
            </div>


            <!-- Modal Create -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Jadwal Perkuliahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-exit"></i>
                            </button>
                        </div>
                        <form action="{{ route('jadwal.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Tahun Ajaran</label>
                                    <input class="form-control" type="text" id="formText" placeholder="2025/2026 Genap"
                                        name="tahun_ajaran">
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">File Jadwal</label>
                                    <input class="form-control" type="file" id="formFile" name="file">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-label-secondary btn-round" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-label-success btn-round">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tahun Ajaran</th>
                                        <th>File</th>
                                        <th>Dibuat Pada</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $j)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $j->tahun_ajaran }}</td>
                                        <td>{{ $j->file }}</td>
                                        <td>{{ $j->created_at->format('d M Y') }}</td>
                                        <td class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('jadwal.detail', $j->id) }}"
                                                class="btn btn-warning btn-sm" title="Lihat">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $j->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            <!-- Form Hapus -->
                                            <form id="delete-form-{{ $j->id }}"
                                                action="{{ route('jadwal.destroy', $j->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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