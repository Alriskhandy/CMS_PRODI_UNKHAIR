@extends('backend.layouts.main')

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="page-header">
                <h3 class="fw-bold mb-3 fs-3">Profile User</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">

                <!-- Update Profile Information Form -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ubah Nama & Email</h5>
                    </div>
                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-outline-primary">Perbarui Profil</button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">

                <!-- Update Password Form -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Ubah Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Lama</label>
                                <input type="password"
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password"
                                    class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" required>
                                @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-outline-primary">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection