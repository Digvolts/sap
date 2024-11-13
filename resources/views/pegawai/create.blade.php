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
    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama" required>
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" placeholder="NIP (e.g., 12345678 123456 1 123)">
    @error('nip')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="text" class="form-control @error('golongan') is-invalid @enderror" id="golongan" name="golongan" placeholder="Golongan (e.g., Penata / III-c)">
    @error('golongan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" placeholder="Jabatan 1" required>
    @error('jabatan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="text" class="form-control @error('no_handphone') is-invalid @enderror" id="no_handphone" name="no_handphone" placeholder="No. Handphone">
    @error('no_handphone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp" name="npwp" placeholder="NPWP (e.g., 12.345.678.9-123.456)">
    @error('npwp')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <input type="text" class="form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp" placeholder="KTP (e.g., 1234567890123456)">
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
        $('#nama, #jabatan').on('focusout', function() {
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
