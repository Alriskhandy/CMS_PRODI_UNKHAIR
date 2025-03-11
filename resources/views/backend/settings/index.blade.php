@extends('backend.layouts.main', ['title' => 'Settings'])

@section('body')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div class="page-header">
                    <h3 class="fw-bold mb-3 fs-3">Pengaturan</h3>
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
                            <a href="#">Pengaturan</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">Umum</a>
                        </li>
                    </ul>
                </div>
                <div class="ms-md-auto py-2 py-md-0">
                    {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
                    {{-- <a href="{{ route('backup.download') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i>
                        Backup Database</a>
                    <a href="{{ route('backup.storage') }}" class="btn btn-primary btn-round"><i class="fa fa-plus"></i>
                        Backup Storage</a> --}}
                </div>
            </div>
            <div class="row">
                <div class="card">
                    {{-- <div class="card-header">
                        <h4 class="card-title">Settings</h4>
                    </div> --}}
                    <div class="card-body">
                        <div class="row py-2">
                            <div class="col-lg-8">
                                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                    <div class="tab-content" id="v-pills-without-border-tabContent">
                                        @csrf
                                        <div class="tab-pane fade active show" id="v-pills-site-settings" role="tabpanel"
                                            aria-labelledby="v-pills-site-settings-tab">
                                            <input type="hidden" name="tab" id="activeTab" value="site">
                                            <div class="mb-3">
                                                <label for="site_name" class="form-label">Nama Situs</label>
                                                <input type="text" name="site_name" id="site_name"
                                                    value="{{ $settings['site_name'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-6">
                                                    <label for="site_logo" class="form-label">Upload Logo Situs</label>
                                                    <input type="file" name="site_logo" id="site_logo" accept="image/*"
                                                        class="form-control">
                                                </div>
                                                <div class="col-6">
                                                    @if (isset($settings['site_logo']))
                                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                                            alt="Logo" class="mt-2" style="max-width: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- <div class="mb-3">
                                                <label for="app_url" class="form-label">App URL</label>
                                                <input type="text" name="app_url" id="app_url"
                                                    value="{{ $settings['app_url'] ?? '' }}" class="form-control">
                                            </div> --}}
                                            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="col-5 col-md-4">
                                <div class="nav flex-column nav-pills nav-secondary nav-pills-no-bd"
                                    id="v-pills-tab-without-border" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="v-pills-site-settings-tab" data-bs-toggle="pill"
                                        href="#v-pills-site-settings" role="tab" aria-controls="v-pills-site-settings"
                                        aria-selected="true">Site Settings</a>
                                    <a class="nav-link" id="v-pills-email-settings-tab" data-bs-toggle="pill"
                                        href="#v-pills-email-settings" role="tab" aria-controls="v-pills-email-settings"
                                        aria-selected="false">Email Settings</a>
                                    <a class="nav-link" id="v-pills-database-settings-tab" data-bs-toggle="pill"
                                        href="#v-pills-database-settings" role="tab"
                                        aria-controls="v-pills-database-settings" aria-selected="false">Database
                                        Settings</a>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <!-- Hidden input untuk tab yang aktif -->
                                <!-- Site Settings Tab -->
                                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                                    <div class="tab-content" id="v-pills-without-border-tabContent">
                                        @csrf
                                        <div class="tab-pane fade active show" id="v-pills-site-settings" role="tabpanel"
                                            aria-labelledby="v-pills-site-settings-tab">
                                            <input type="hidden" name="tab" id="activeTab" value="site">
                                            <div class="mb-3">
                                                <label for="site_name" class="form-label">Nama Situs</label>
                                                <input type="text" name="site_name" id="site_name"
                                                    value="{{ $settings['site_name'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3 row">
                                                <div class="col-6">
                                                    <label for="site_logo" class="form-label">Upload Logo Situs</label>
                                                    <input type="file" name="site_logo" id="site_logo" accept="image/*"
                                                        class="form-control">
                                                </div>
                                                <div class="col-6">
                                                    @if (isset($settings['site_logo']))
                                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                                            alt="Logo" class="mt-2" style="max-width: 100px;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="app_url" class="form-label">App URL</label>
                                                <input type="text" name="app_url" id="app_url"
                                                    value="{{ $settings['app_url'] ?? '' }}" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Simpan Pengaturan</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Email Settings Tab -->
                                <form action="{{ route('settings.update') }}" method="POST">
                                    <div class="tab-content" id="v-pills-without-border-tabContent">
                                        @csrf
                                        <div class="tab-pane fade" id="v-pills-email-settings" role="tabpanel"
                                            aria-labelledby="v-pills-email-settings-tab">
                                            <!-- Site Settings Tab -->
                                            <input type="hidden" name="tab" id="activeTab" value="email">
                                            <div class="mb-3">
                                                <label for="mail_mailer" class="form-label">Mailer</label>
                                                <input type="text" name="mail_mailer" id="mail_mailer"
                                                    value="{{ $settings['mail_mailer'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_host" class="form-label">Mail Host</label>
                                                <input type="text" name="mail_host" id="mail_host"
                                                    value="{{ $settings['mail_host'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_port" class="form-label">Mail Port</label>
                                                <input type="text" name="mail_port" id="mail_port"
                                                    value="{{ $settings['mail_port'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_username" class="form-label">Mail Username</label>
                                                <input type="text" name="mail_username" id="mail_username"
                                                    value="{{ $settings['mail_username'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_password" class="form-label">Mail Password</label>
                                                <input type="password" name="mail_password" id="mail_password"
                                                    value="{{ $settings['mail_password'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_encryption" class="form-label">Mail Encryption</label>
                                                <input type="text" name="mail_encryption" id="mail_encryption"
                                                    value="{{ $settings['mail_encryption'] ?? '' }}"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_from_address" class="form-label">Mail From
                                                    Address</label>
                                                <input type="email" name="mail_from_address" id="mail_from_address"
                                                    value="{{ $settings['mail_from_address'] ?? '' }}"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="mail_from_name" class="form-label">Mail From Name</label>
                                                <input type="text" name="mail_from_name" id="mail_from_name"
                                                    value="{{ $settings['mail_from_name'] ?? '' }}" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Simpan Pengaturan</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Database Settings Tab -->
                                <form action="{{ route('settings.update') }}" method="POST">
                                    <div class="tab-content" id="v-pills-without-border-tabContent">
                                        @csrf
                                        <div class="tab-pane fade" id="v-pills-database-settings" role="tabpanel"
                                            aria-labelledby="v-pills-database-settings-tab">
                                            <input type="hidden" name="tab" id="activeTab" value="database">
                                            <div class="mb-3">
                                                <label for="database_connection" class="form-label">Database
                                                    Connection</label>
                                                <input type="text" name="database_connection" id="database_connection"
                                                    value="{{ $settings['database_connection'] ?? '' }}"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="database_host" class="form-label">Database Host</label>
                                                <input type="text" name="database_host" id="database_host"
                                                    value="{{ $settings['database_host'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="database_port" class="form-label">Database Port</label>
                                                <input type="text" name="database_port" id="database_port"
                                                    value="{{ $settings['database_port'] ?? '' }}" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="database_name" class="form-label">Database Name</label>
                                                <input type="text" name="database_name" id="database_name"
                                                    value="{{ $settings['database_name'] ?? '' }}" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Simpan Pengaturan</button>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Script untuk menjaga tab tetap aktif setelah pengiriman form
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = '{{ session('tab', 'site') }}'; // Default ke tab 'site' jika tidak ada yang aktif
            var tabLink = document.querySelector('[href="#v-pills-' + activeTab + '-settings"]');
            if (tabLink) {
                tabLink.click();
            }
        });
    </script>
@endpush
