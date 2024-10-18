@extends('layouts.app')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header text-center">
            <h1 class="text-primary font-weight-bold">Tambah Pegawai Baru</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('pegawai.store') }}" method="POST">
                @csrf

                <input type="hidden" name="unit" value="unit 54">
                <input type="hidden" name="direktorat" value="kemuliaan">

                <div class="form-group">
                    <label for="nama" class="col-form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nip" class="col-form-label">NIP</label>
                    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"  placeholder="12345678 123456 1 123" >
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="golongan" class="col-form-label">Golongan</label>
                    <input type="text" class="form-control @error('golongan') is-invalid @enderror" id="golongan" name="golongan" >
                    @error('golongan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Contoh: Penata / III-c</small>
                </div>
                <div class="form-group">
                    <label for="jabatan_1" class="col-form-label">Jabatan 1</label>
                    <input type="text" class="form-control @error('jabatan_1') is-invalid @enderror" id="jabatan_1" name="jabatan_1" required>
                    @error('jabatan_1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jabatan_2" class="col-form-label">Jabatan 2</label>
                    <input type="text" class="form-control @error('jabatan_2') is-invalid @enderror" id="jabatan_2" name="jabatan_2">
                    @error('jabatan_2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_handphone" class="col-form-label">No. Handphone</label>
                    <input type="text" class="form-control @error('no_handphone') is-invalid @enderror" id="no_handphone" name="no_handphone" >
                    @error('no_handphone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="npwp" class="col-form-label">NPWP</label>
                    <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp" name="npwp"  placeholder="12.345.678.9-123.456">
                    @error('npwp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ktp" class="col-form-label">KTP</label>
                    <input type="text" class="form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp"  placeholder="1234567890123456">
                    @error('ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="col-form-label">Status</label>
                    <div>
                        <input type="hidden" name="status" value="pegawai"> <!-- Default value -->
                        <input type="checkbox" id="status" name="status" value="nonpegawai" onchange="updateStatus(this)">
                        <label for="status" class="ml-2">Non-Pegawai</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
            </form>
        </div>
    </div>
</div>

<style>
  
</style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nip').inputmask('99999999 999999 9 999'); // Input mask for NIP
        $('#npwp').inputmask('99.999.999.9-999.999'); // Input mask for NPWP
        $('#ktp').inputmask('9999999999999999'); // Input mask for KTP

        // Validation for required fields on focus out
        $('#nama, #jabatan_1').on('focusout', function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid'); // Add invalid class
                $(this).next('.invalid-feedback').show(); // Show error message
            } else {
                $(this).removeClass('is-invalid'); // Remove invalid class
                $(this).next('.invalid-feedback').hide(); // Hide error message
            }
        });
    });
</script>


@endsection
