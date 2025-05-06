@extends('backend.layouts.main', ['title' => 'Rencana Pembelajaran Semester'])

@section('body')

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-2">
                <div class="page-header">
                    <h3 class="fw-bold mb-3 fs-3">Rencana Pembelajaran Semester</h3>
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
                             <a href="#">RPS</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($rps != null)
                        <form action="{{ route('rps.update', $rps->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">File RPS</label>
                                    <input class="form-control" type="file" id="formFile" name="file">
                                    <small>File Saat ini: {{ $rps->file }}</small>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                                    <textarea name="deskripsi" id="editor" class="form-control"
                                        rows="10">{{ $rps->deskripsi }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-success btn-round me-2">Ubah</button>
                                <button type="button" class="btn btn-outline-danger btn-round"
                                    onclick="confirmDelete({{ $rps->id }})" title="Delete">
                                    Hapus
                                </button>
                            </div>
                        </form>
                        <!-- Form Hapus (tidak boleh berada dalam form lain) -->
                        <form id="delete-form-{{ $rps->id }}" action="{{ route('rps.destroy', $rps->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                        @else
                        <form action="{{ route('rps.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">File RPS</label>
                                    <input class="form-control" type="file" id="formFile" name="file">
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                                    <textarea name="deskripsi" id="editor" class="form-control" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-success btn-round">Simpan</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="mb-0 font-bold">Preview File RPS</h1>
                    </div>
                    <div class="card-body text-center">
                        @if ($rps && $rps->file)
                        <iframe src="{{ asset('storage/' . $rps->file) }}" width="100%" height="650px"
                            style="border: none;">
                        </iframe>
                        @else
                        <h3>Rencana Pembelajaran Semester belum diupload.</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
    @endsection

    @push('scripts')
    <!-- TinyMCE Editor & Notify.js -->
    <script src="{{ asset('backend/tinymce/tinymce.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify.js/0.4.2/notify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        tinymce.init({
            selector: '#editor',
            height: 200,
            menubar: 'file edit view insert format tools table help',
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic underline strikethrough | ' +
                     'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
                     'outdent indent | numlist bullist | removeformat | ' +
                     'table link image media | code fullscreen preview',
            toolbar_mode: 'sliding',
            content_css: [
                'https://www.tiny.cloud/css/codepen.min.css'
            ],
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    let route_prefix = "{{ url('cms-unkhair-filemanager') }}";
                    window.open(route_prefix + '?type=file', 'FileManager', 'width=800,height=600');

                    window.SetUrl = function(items) {
                        let file_url = items[0].url;
                        callback(file_url, {
                            alt: items[0].name
                        });
                    };
                }
            },
            setup: function(editor) {
                editor.on('NodeChange', function(e) {
                    if (e.element && e.element.nodeName === 'IMG') {
                        e.element.style.maxWidth = '100%';
                        e.element.style.height = 'auto';
                    }
                });

                editor.on('change', function() {
                    editor.save(); // Simpan ke textarea
                });
            }
        });

        // Konfirmasi hapus data
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
    </script>
    @endpush