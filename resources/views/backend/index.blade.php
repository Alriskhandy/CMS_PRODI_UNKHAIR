@extends('backend.layouts.main', ['title' => 'Dashboard'])

@section('body')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3 fs-3">Dashboard</h3>
                <h3 class="fw-bold fs-5 mb-2">Selamat Datang !</h3>
                <h6>Halo {{ Auth::user()->name }}</h6>
                <h6>Selamat datang di CMS Panel, silahkan akses menu di samping untuk manajemen konten dan website.</h6>
            </div>
        </div>
        <div class="row"></div>
    </div>
</div>
@endsection