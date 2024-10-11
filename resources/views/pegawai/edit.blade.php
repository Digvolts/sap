@extends('layouts.app')

@section('content')
    <h1>Edit Data Pegawai</h1>
    <form action="{{ route('pegawai.update', $pegawai) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $pegawai->nama }}" required>
        </div>
        <div class="form-group">
            <label for="nip">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" value="{{ $pegawai->nip }}" required pattern="\d{8} \d{6} \d \d{3}" placeholder="12345678 123456 1 123">
        </div>
        <div class="form-group">
            <label for="golongan">Golongan</label>
            <input type="text" class="form-control" id="golongan" name="golongan" value="{{ $pegawai->golongan }}" required>
        </div>
        <div class="form-group">
            <label for="jabatan_1">Jabatan 1</label>
            <input type="text" class="form-control" id="jabatan_1" name="jabatan_1" value="{{ $pegawai->jabatan_1 }}" required>
        </div>
        <div class="form-group">
            <label for="jabatan_2">Jabatan 2</label>
            <input type="text" class="form-control" id="jabatan_2" name="jabatan_2" value="{{ $pegawai->jabatan_2 }}">
        </div>
        <div class="form-group">
            <label for="no_handphone">No. Handphone</label>
            <input type="text" class="form-control" id="no_handphone" name="no_handphone" value="{{ $pegawai->no_handphone }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $pegawai->email }}" required>
        </div>
        <div class="form-group">
            <label for="npwp">NPWP</label>
            <input type="text" class="form-control" id="npwp" name="npwp" value="{{ $pegawai->npwp }}" required pattern="\d{2}.\d{3}.\d{3}.\d-\d{3}.\d{3}" placeholder="12.345.678.9-123.456">
        </div>
        <div class="form-group">
            <label for="ktp">KTP</label>
            <input type="text" class="form-control" id="ktp" name="ktp" value="{{ $pegawai->ktp }}" required pattern="\d{4} \d{4} \d{4} \d{4}" placeholder="1234 5678 9012 3456">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="{{ $pegawai->status }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
@endsection
