@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('template/back/dist/libs/select2/dist/css/select2.min.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="card bg-light-info shadow-none position-relative overflow-hidden" style="border: solid 0.5px #ccc;">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">{{ $title }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('users.index') }}">Halaman User</a></li>
                            <li class="breadcrumb-item">{{ $subtitle }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3 text-center">
                    <img src="{{ asset('template/back/dist/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>

    <section class="datatables">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada beberapa masalah dengan data yang anda masukkan.
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('users.update', $data_user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label><strong>Nama:</strong></label>
                                        <input type="text" name="name" class="form-control" value="{{ $data_user->name }}" placeholder="Nama">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label><strong>Email:</strong></label>
                                        <input type="email" name="email" class="form-control" value="{{ $data_user->email }}" placeholder="Email">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label><strong>Password:</strong></label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label><strong>Konfirmasi Password:</strong></label>
                                        <input type="password" name="confirm-password" class="form-control" placeholder="Konfirmasi Password">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label><strong>Role:</strong></label>
                                        <select name="roles[]" class="select2 form-control" multiple="multiple">
                                            <option></option>
                                            <optgroup label="--Pilih Role--">
                                                @foreach ($roles as $value => $label)
                                                <option value="{{ $value }}" {{ in_array($value, $usersRole) ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa fa-save"></i> Update</button>
                                        <a class="btn btn-warning btn-sm mt-2 mb-3" href="{{ route('users.index') }}"><i class="fa fa-undo"></i> Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('script')
<script src="{{ asset('template/back/dist/libs/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "--Pilih Role--",
            allowClear: true
        });
    });
</script>
@endpush
