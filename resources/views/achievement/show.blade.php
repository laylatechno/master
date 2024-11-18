@extends('layouts.app')

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
                            <li class="breadcrumb-item" aria-current="page"><a class="text-muted text-decoration-none" href="{{ route('achievements.index') }}">Halaman Pencapaian</a></li>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Kategori Perkembangan:</strong>
                                        {{ $data_achievement->developmentCategory->name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Nama:</strong>
                                        {{ $data_achievement->name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Referensi:</strong>
                                        {{ $data_achievement->reference }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Deskripsi:</strong>
                                        {{ $data_achievement->description }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Urutan:</strong>
                                        {{ $data_achievement->position }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Durasi:</strong>
                                        {{ $data_achievement->duration }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Usia:</strong>
                                        {{ $data_achievement->age }}
                                    </div>
                                </div>


                                <!-- Menampilkan Stimuli -->
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Stimuli Terkait:</strong>
                                        <ul>
                                            @foreach($data_achievement->stimuli as $stimulus)
                                            <li>{{ $stimulus->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Menampilkan Products -->
                                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-item">
                                        <strong>Produk Terkait:</strong>
                                        <ul>
                                            @foreach($data_achievement->products as $product)
                                            <li>{{ $product->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-warning mb-2 mt-3" href="{{ route('achievements.index') }}"><i class="fa fa-undo"></i> Kembali</a>

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