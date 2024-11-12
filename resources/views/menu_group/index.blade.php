@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css" />
@endpush
<style>
    .card-header {
        display: flex;
        justify-content: space-between;
        /* Membuat ruang antara nama dan tombol */
        align-items: center;
        /* Menjaga tombol sejajar vertikal dengan teks */
    }

    .card-header .d-flex {
        display: flex;
    }

    .card-header .ml-auto {
        margin-left: auto;
        /* Menempatkan elemen ke sisi kanan */
    }

    .card-footer {
        padding: 10px;
    }
</style>

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
    <div class="row mb-4">
        <div class="col-lg-12 margin-tb">

            <div class="pull-right">
                @can('menugroup-create')
                <a class="btn btn-success mb-2" href="{{ route('menu_group.create') }}"><i class="fa fa-plus"></i> Tambah Data</a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Kanban -->
    <section class="kanban">
        <div class="row">
            @foreach ($data_menu_group as $menu_group)
            <div class="col-12 mb-4"> <!-- Menggunakan col-12 agar setiap card memakan satu baris penuh -->
                <div class="card" data-id="{{ $menu_group->id }}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between w-100">
                            <h5>{{ $menu_group->name }}</h5> <!-- Ukuran ikon diperbesar -->


                        </div>
                        <!-- Tombol Edit dan Hapus di sebelah kanan -->
                        <div class="ml-auto d-flex gap-2">
                            <a class="btn btn-sm {{ $menu_group->status == 'Aktif' ? 'btn-success' : 'btn-warning' }}" href="{{ route('menu_group.show',$menu_group->id) }}">
                                <i class="fa {{ $menu_group->status == 'Aktif' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $menu_group->status }}
                            </a>

                            @can('menugroup-edit')
                            <a class="btn btn-primary btn-sm" href="{{ route('menu_group.edit', $menu_group->id) }}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            @endcan
                            @can('menugroup-delete')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $menu_group->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                            <form id="delete-form-{{ $menu_group->id }}" method="POST" action="{{ route('menu_group.destroy', $menu_group->id) }}" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>




</div>
@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(itemId) {
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
                document.getElementById('delete-form-' + itemId).submit();
            }
        });
    }
</script>

<script>
    // Inisialisasi SortableJS untuk membuat kolom menjadi dapat dipindah-pindah
    document.addEventListener('DOMContentLoaded', function() {
        const kanbanContainer = document.querySelector('.kanban .row');
        new Sortable(kanbanContainer, {
            group: 'kanban', // Menentukan grup untuk drag-and-drop antar kolom
            animation: 150,
            onEnd: function(evt) {
                let sortedItems = [];
                kanbanContainer.querySelectorAll('.card').forEach(function(card) {
                    sortedItems.push(card.getAttribute('data-id'));
                });

                // Kirimkan data ID yang terurut ke server untuk disimpan
                fetch("{{ route('menu_group.update_positions') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            positions: sortedItems
                        }), // Kirim posisi
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Posisi Group berhasil diperbarui');
                            location.reload();
                        } else {
                            alert('Terjadi kesalahan');
                        }
                    });
            }
        });
    });
</script>
@endpush