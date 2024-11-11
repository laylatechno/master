@extends('layouts.app')
@section('title', $title)
@section('subtitle', $subtitle)

@push('css')
<link rel="stylesheet" href="{{ asset('template/back') }}/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
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
                                <div class="col-lg-12 margin-tb">

                                    <div class="pull-right">
                                        @can('role-create')
                                        <a class="btn btn-success mb-2" href="{{ route('menu_group.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>

                            @session('success')
                            <div class="alert alert-success" roles="alert">
                                {{ $value }}
                            </div>
                            @endsession
                            <table id="zero_config"
                                class="table border table-striped table-bordered text-nowrap">
                                <thead>
                                    <!-- start row -->
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nama Permission</th>
                                        <th>Status</th>
                                        <th>Urutan</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <!-- end row -->
                                </thead>
                                <tbody>
                                    @foreach ($data_menu_group as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->permission_name }}</td>
                                        <td>{{ $p->status }}</td>
                                        <td>{{ $p->position }}</td>
                                        <td>
                                            <a class="btn btn-warning btn-sm" href="{{ route('menu_group.show',$p->id) }}"><i class="fa fa-eye"></i> Show</a>
                                            @can('role-edit')
                                            <a class="btn btn-primary btn-sm" href="{{ route('menu_group.edit',$p->id) }}"><i class="fa fa-edit"></i> Edit</a>
                                            @endcan

                                            @can('role-delete')
                                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $p->id }})">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $p->id }}" method="POST" action="{{ route('menu_group.destroy', $p->id) }}" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


</div>
@endsection



@push('script')
<script>
    function confirmDelete(rolesId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + rolesId).submit();
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('template/back') }}/dist/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('template/back') }}/dist/js/datatable/datatable-basic.init.js"></script>
@endpush