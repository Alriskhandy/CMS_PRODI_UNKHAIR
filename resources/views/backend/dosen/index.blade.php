@extends('backend.layouts.main', ['title' => 'Daftar Dosen'])

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="page-header">
                <h3 class="fw-bold mb-3 fs-3">Daftar Dosen</h3>
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
                        <a href="#">Daftar Dosen</a>
                    </li>
                </ul>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <!-- Button trigger modal -->
                <a href="{{ route('dosen.create') }}" class="btn btn-label-info btn-round me-2">
                    <i class="fa fa-plus"></i> Tambah Dosen
                </a>
            </div>


        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Dosen</th>
                                        <th>NIP / NIDN</th>
                                        <th>Jabatan</th>
                                        <th>Foto</th>
                                        <th>Ditambahkan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dosen as $d)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td>{{ $d->nip }} / {{ $d->nidn }}</td>
                                        <td>{{ $d->jabatan }}</td>

                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . $d->foto) }}" alt="Foto {{ $d->nama }}"
                                                class="img-thumbnail rounded-circle d-block mx-auto"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        </td>

                                        <td class="text-center">{{ $d->created_at->translatedFormat('d F Y H:i') }}</td>

                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('dosen.edit', $d->id) }}"
                                                    class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $d->id }})" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Form Hapus -->
                                            <form id="delete-form-{{ $d->id }}"
                                                action="{{ route('dosen.destroy', $d->id) }}" method="POST"
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