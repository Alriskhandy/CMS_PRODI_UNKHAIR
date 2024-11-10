<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ @$title != '' ? "$title - " : '' }}{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('backend/assets/img/logo-unkhair.png') }}" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('backend/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('backend/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/kaiadmin.min.css') }}" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- SweetAlert2 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" /> --}}

    {{-- summernote --}}


    @notifyCss
    <style>
        .notify {
            z-index: 99999999 !important;
            /* Pastikan menggunakan !important jika ada aturan lain yang mempengaruhi */
            position: fixed;
            /* Mengatur posisi menjadi tetap */
            bottom: 20px;
            /* Jarak dari bagian bawah */
            right: 20px;
            /* Jarak dari sisi kanan */
        }

        /* Menetapkan ukuran maksimal untuk logo */
        .navbar-brand {
            max-height: 20px;
            /* Atur tinggi maksimum logo */
            height: auto;
            /* Memastikan proporsional */
            width: auto;
            /* Memastikan proporsional */
            display: block;
            /* Menghindari efek whitespace */
        }

        .loader-overlay {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
            /* Default hidden */
        }

        .custom-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .loader-logo {
            width: 100px;
            /* Sesuaikan ukuran logo */
            height: auto;
        }
    </style>
    @stack('css')
    <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/lfm.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/dropzone.min.css') }}">
</head>

<body>
    @include('sweetalert::alert')
    <div class="wrapper">
        {{-- sidebar --}}
        @include('backend.layouts.sidebar')

        <div class="main-panel">
            {{-- header --}}
            @include('backend.layouts.header')

            @yield('body')

            {{-- footer --}}
            @include('backend.layouts.footer')
        </div>
    </div>

    <!-- Custom Loader -->
    <div id="loader" class="loader-overlay">
        <div class="custom-loader">
            <img src="{{ asset('backend\assets\img\logo-unkhair.png') }}" alt="Universitas Khairun Logo"
                class="loader-logo">
            <div class="spinner-border text-primary mt-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>



    <!--   Core JS Files   -->
    <script src="{{ asset('backend/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('backend/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('backend/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('backend/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('backend/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('backend/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('backend/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('backend/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <!-- Google Maps Plugin -->
    <script src="{{ asset('backend/assets/js/plugin/gmaps/gmaps.js') }}"></script>

    <!-- Sweet Alert -->
    {{-- <script src="{{ asset('backend/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('backend/assets/js/kaiadmin.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({});
        });
    </script>


    @stack('scripts')
    <!-- Include Laravel File Manager's script -->
    <script src="{{ asset('vendor/laravel-filemanager/js/filemanager.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/dropzone.min.js') }}"></script>
    <script>
        // sweetalert
        function showLoader() {
            document.getElementById('loader').style.display = 'flex';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoader();
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        // Handle file selection
        window.addEventListener('message', function(event) {
            if (event.origin === "{{ url('/') }}") {
                var data = event.data;
                if (data && data.link) {
                    console.log('File URL:', data.link); // Handle the file URL as needed
                    // Example: Show the selected file URL in an alert
                    alert('File URL: ' + data.link);
                }
            }
        }, false);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sembunyikan loader setelah halaman selesai dimuat
            document.getElementById('loader').style.display = 'none';

            // Menampilkan loader saat pengiriman form
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    showLoader();
                });
            });

            // // Menampilkan loader saat tautan diklik, hanya jika benar-benar memindahkan halaman dan bukan dropdown/tab
            // document.querySelectorAll('a').forEach(function(link) {
            //     link.addEventListener('click', function(event) {
            //         const href = link.getAttribute('href');
            //         const isDropdown = link.hasAttribute('data-toggle') && (link.getAttribute(
            //                 'data-toggle') === 'dropdown' || link.getAttribute(
            //             'data-bs-toggle') === 'dropdown');
            //         const isTab = link.hasAttribute('data-toggle') && (link.getAttribute(
            //                 'data-toggle') === 'tab' || link.getAttribute('data-bs-toggle') ===
            //             'tab');

            //         // Tampilkan loader hanya jika:
            //         // - href ada dan bukan '#' atau kosong
            //         // - bukan dropdown atau tab navigasi
            //         // - tidak memiliki target="_blank"
            //         if (href && href !== '#' && href.trim() !== '' && !isDropdown && !isTab && !link
            //             .hasAttribute('target')) {
            //             showLoader();
            //         }
            //     });
            // });

            // Menampilkan loader saat tombol dengan data-action="delete" diklik
            document.querySelectorAll('[data-action="delete"]').forEach(function(button) {
                button.addEventListener('click', function() {
                    showLoader();
                });
            });

            // Menampilkan loader saat AJAX request dibuat (contoh menggunakan fetch)
            function showLoaderOnFetch() {
                const originalFetch = window.fetch;
                window.fetch = function() {
                    showLoader(); // Tampilkan loader sebelum request
                    return originalFetch.apply(this, arguments)
                        .finally(() => {
                            document.getElementById('loader').style.display =
                                'none'; // Sembunyikan loader setelah request selesai
                        });
                };
            }

            // Panggil fungsi untuk memonitor AJAX menggunakan fetch API
            showLoaderOnFetch();
        });

        // Fungsi untuk menampilkan loader
        function showLoader() {
            document.getElementById('loader').style.display = 'flex';
        }
    </script>



    <x-notify::notify />
    @notifyJs

</body>

</html>
