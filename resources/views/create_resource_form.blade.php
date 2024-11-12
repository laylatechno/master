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
                            <li class="breadcrumb-item" aria-current="page"><a class="text-muted text-decoration-none" href="{{ route('roles.index') }}">Halaman Create Modul</a></li>
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

                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> Ada beberapa masalah dengan data yang anda masukkan.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif


                            <form action="{{ route('resource.store') }}" method="POST">
                                @csrf
                                <label for="nama_table">Nama Table:</label>
                                <input type="text" name="nama_table" class="form-control mb-3" required>

                                <div id="fields-container" class="mb-3">
                                    <div class="row field-group mb-3">
                                        <div class="col-4 mb-2">
                                            <label>Nama Field:</label>
                                            <input type="text" class="form-control" name="fields[0][name]" required>
                                        </div>
                                        <div class="col-4">
                                            <label>Tipe Data:</label>
                                            <select name="fields[0][type]" class="form-control">
                                                <option value="string">String</option>
                                                <option value="integer">Integer</option>
                                                <!-- Tambahkan tipe data lain sesuai kebutuhan -->
                                            </select>
                                        </div>
                                        <div class="col-3 d-flex align-items-end">
                                            <button class="btn btn-danger btn-sm" type="button" onclick="removeField(this)">Hapus</button>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-sm" type="button" onclick="addField()"><i class="fa fa-plus"></i> Tambah Field</button>
                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-save"></i> Buat Resource</button>
                            </form>

                            <script>
                                function addField() {
                                    const container = document.getElementById('fields-container');
                                    const fieldCount = container.children.length;
                                    const newField = document.createElement('div');
                                    newField.classList.add('row', 'field-group', 'mb-2');
                                    newField.innerHTML = `
                                        <div class="col-4">
                                            <label>Nama Field:</label>
                                            <input class="form-control" type="text" name="fields[${fieldCount}][name]" required>
                                        </div>
                                        <div class="col-4">
                                            <label>Tipe Data:</label>
                                            <select name="fields[${fieldCount}][type]" class="form-control">
                                                <option value="string">String</option>
                                                <option value="integer">Integer</option>
                                                <!-- Tambahkan tipe data lain sesuai kebutuhan -->
                                            </select>
                                        </div>
                                        <div class="col-3 d-flex align-items-end">
                                            <button class="btn btn-danger btn-sm" type="button" onclick="removeField(this)">Hapus</button>
                                        </div>
                                    `;
                                    container.appendChild(newField);
                                }

                                function removeField(button) {
                                    const fieldGroup = button.closest('.field-group');
                                    fieldGroup.remove();
                                }
                            </script>
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