<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    @if (Request::is('/'))
    <!-- Primary Meta Tags -->
    <title>{{ $site_name->value }}</title>
    <meta name="title" content="{{ $site_name->value }}">
    <meta name="description"
        content="Universitas Khairun adalah Perguruan Tinggi Negeri terkemuka di Ternate, Maluku Utara. Menawarkan program Sarjana, Magister & Doktor dengan akreditasi unggul. Memiliki 8 fakultas dengan 40+ program studi dalam bidang sains, teknologi, sosial & humaniora.">
    <meta name="keywords"
        content="universitas khairun, unkhair, kampus ternate, universitas negeri ternate, ptn ternate, kuliah di ternate, fakultas unkhair, pendaftaran unkhair, beasiswa unkhair, biaya kuliah unkhair, pmb unkhair, jalur masuk unkhair, akreditasi unkhair, jurusan unkhair, program studi unkhair">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Indonesia">
    <meta name="author" content="Universitas Khairun">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('') }}">
    <meta property="og:title" content="{{ $site_name->value }}">
    <meta property="og:description"
        content="Universitas Khairun adalah Perguruan Tinggi Negeri terkemuka di Ternate, Maluku Utara. Menawarkan program Sarjana, Magister & Doktor dengan akreditasi unggul.">
    <meta property="og:image" content="{{ asset('storage/' . $site_logo->value) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('') }}">
    <meta property="twitter:title" content="{{ $site_name->value }}">
    <meta property="twitter:description"
        content="Universitas Khairun adalah Perguruan Tinggi Negeri terkemuka di Ternate, Maluku Utara. Menawarkan program Sarjana, Magister & Doktor dengan akreditasi unggul.">
    <meta property="twitter:image" content="{{ asset('storage/' . $site_logo->value) }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('') }}">

    <!-- Additional Meta Tags -->
    <meta name="geo.region" content="ID-MA" />
    <meta name="geo.placename" content="Ternate" />
    <meta name="geo.position" content="0.7714;127.3771" />
    <meta name="ICBM" content="0.7714, 127.3771" />

    <!-- Cache Control -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    @endif

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('favicon/apple-touch-icon-57x57.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ asset('favicon/apple-touch-icon-114x114.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('favicon/apple-touch-icon-72x72.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ asset('favicon/apple-touch-icon-144x144.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('favicon/apple-touch-icon-60x60.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120"
        href="{{ asset('favicon/apple-touch-icon-120x120.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('favicon/apple-touch-icon-76x76.png') }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
        href="{{ asset('favicon/apple-touch-icon-152x152.png') }}" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-196x196.png') }}" sizes="196x196" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-16x16.png') }}" sizes="16x16" />
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-128.png') }}" sizes="128x128" />

    <!-- Microsoft Tiles -->
    <meta name="application-name" content="&nbsp;" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="{{ asset('favicon/mstile-144x144.png') }}" />
    <meta name="msapplication-square70x70logo" content="{{ asset('favicon/mstile-70x70.png') }}" />
    <meta name="msapplication-square150x150logo" content="{{ asset('favicon/mstile-150x150.png') }}" />
    <meta name="msapplication-wide310x150logo" content="{{ asset('favicon/mstile-310x150.png') }}" />
    <meta name="msapplication-square310x310logo" content="{{ asset('favicon/mstile-310x310.png') }}" />


    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('themes/simple-blog/css/styles.css') }}" rel="stylesheet" />

    <!-- Add Head Stack -->
    @stack('head')

    <!-- Other Styles -->
    @stack('styles')
</head>

<body>
    <!-- Header-->
    @include('themes.simple-blog.layouts.header')


    <!-- Main Page-->
    @yield('main')

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">&copy; Copyright {{ $site_name->value }}. <span>All
                Rights
                Reserved</span></p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('themes/simple-blog/js/scripts.js') }}"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 992) {
                const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
                const navMenu = document.querySelector('.navmenu');

                // Toggle untuk menu utama mobile
                if (mobileNavToggle) {
                    mobileNavToggle.addEventListener('click', function(e) {
                        navMenu.classList.toggle('navbar-mobile');
                        this.classList.toggle('bi-x');
                    });
                }

                // Handler untuk dropdown level 1
                document.querySelectorAll('.navmenu .dropdown').forEach(function(dropdown) {
                    const dropdownToggle = dropdown.querySelector('.dropdown-toggle');
                    const dropdownMenu = dropdown.querySelector('.dropdown-menu');

                    dropdownToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropdownMenu.classList.toggle('dropdown-active');
                    });
                });

                // Handler untuk dropdown level 2 dan 3
                document.querySelectorAll('.dropdown-menu .dropdown').forEach(function(dropdown) {
                    const link = dropdown.querySelector('a');
                    const subMenu = dropdown.querySelector('ul');

                    if (link && subMenu) {
                        link.addEventListener('click', function(e) {
                            if (this.classList.contains('dropdown-toggle')) {
                                e.preventDefault();
                                e.stopPropagation();
                                subMenu.classList.toggle('dropdown-active');
                            }
                        });
                    }
                });
            }
        });

        grecaptcha.ready(function() {
            grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                action: 'submit'
            }).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>
</body>

</html>