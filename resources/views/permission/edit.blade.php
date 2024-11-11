@extends('layouts.app')
@push('css')

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
                            <li class="breadcrumb-item" aria-current="page"><a class="text-muted text-decoration-none" href="{{ route('permission.index') }}">Halaman User</a></li>
                            <li class="breadcrumb-item" aria-current="page">{{ $subtitle }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('template/back') }}/dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="datatables">
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">


                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada beberapa masalah dengan data yang anda masukka.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('permission.update', $data_permission->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-group">
                                            <strong>Nama:</strong>
                                            <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $data_permission->name }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                        <div class="form-group">
                                            <strong>Guard:</strong>
                                            <input type="text" name="guard_name" placeholder="Guard" class="form-control" value="{{ $data_permission->guard_name }}">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 mb-3"><i class="fa fa-save"></i> Update</button>
                                        <a class="btn btn-warning btn-sm mt-2 mb-3" href="{{ route('permission.index') }}"><i class="fa fa-undo"></i> Kembali</a>
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
  
@endpush