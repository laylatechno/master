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
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('products.index') }}">Halaman Stimulus</a></li>
                            <li class="breadcrumb-item">{{ $subtitle }}</li>
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

                            <form method="POST" action="{{ route('products.update', $data_product->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{ $data_product->name }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="price">Harga</label>
                                    <input type="text" name="price" class="form-control" id="price" placeholder="Contoh: 12,345.67" oninput="formatPrice(this)" value="{{ $data_product->price }}">
                                </div>

                                <script>
                                    function formatPrice(input) {
                                        // Menghapus semua karakter non-digit dan non-desimal
                                        let value = input.value.replace(/[^0-9.]/g, '');

                                        // Memastikan hanya ada satu titik desimal
                                        let parts = value.split('.');
                                        if (parts.length > 2) {
                                            parts = [parts[0], parts[1]]; // Hanya ambil bagian sebelum dan sesudah titik pertama
                                        }

                                        // Format bagian sebelum titik desimal (ribuan)
                                        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                                        // Gabungkan kembali bagian desimal jika ada
                                        input.value = parts.join('.');
                                    }
                                </script>
                                <div class="form-group mb-3">
                                    <label for="description">Deskripsi</label>
                                    <textarea class="form-control" name="description" id="description"  required> {{ $data_product->description }}</textarea>

                                </div>

                                <div class="form-group mb-3">
                                    <label for="image">Gambar</label>
                                    <input type="file" name="image" class="form-control" id="image" onchange="previewImage()">

                                    <canvas id="preview_canvas" style="display: none; max-width: 100%; margin-top: 10px;"></canvas>
                                    <img id="preview_image" src="#" alt="Preview Logo" style="display: none; max-width: 100%; margin-top: 10px;">

                                    <script>
                                        function previewImage() {
                                            var previewCanvas = document.getElementById('preview_canvas');
                                            var previewImage = document.getElementById('preview_image');
                                            var fileInput = document.getElementById('image');
                                            var file = fileInput.files[0];
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                var img = new Image();
                                                img.src = e.target.result;

                                                img.onload = function() {
                                                    var canvasContext = previewCanvas.getContext('2d');
                                                    var maxWidth = 300; // Max width diperbesar
                                                    var scaleFactor = maxWidth / img.width;
                                                    var newHeight = img.height * scaleFactor;

                                                    // Atur dimensi canvas
                                                    previewCanvas.width = maxWidth;
                                                    previewCanvas.height = newHeight;

                                                    // Gambar ke canvas
                                                    canvasContext.drawImage(img, 0, 0, maxWidth, newHeight);

                                                    // Tampilkan pratinjau
                                                    previewCanvas.style.display = 'block';
                                                    previewImage.style.display = 'none';
                                                };
                                            };

                                            if (file) {
                                                reader.readAsDataURL(file); // Membaca file sebagai URL data
                                            } else {
                                                // Reset pratinjau jika tidak ada file
                                                previewImage.src = '';
                                                previewCanvas.style.display = 'none';
                                            }
                                        }
                                    </script>
                                </div>

                               

                                <!-- Buttons -->
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa fa-save"></i> Update</button>
                                    <a class="btn btn-warning btn-sm mb-3" href="{{ route('products.index') }}"><i class="fa fa-undo"></i> Kembali</a>
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