@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Surat Tugas</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Unit</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Pegawai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratTugas as $index => $surat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $surat->unit }}</td>
                <td>{{ $surat->nama_kegiatan }}</td>
                <td>{{ $surat->tanggal_kegiatan_mulai }}</td>
                <td>{{ $surat->tanggal_kegiatan_selesai }}</td>
                <td>
                    @foreach($surat->pegawaiPds as $pegawai)
                        {{ $pegawai->nama }}<br>
                    @endforeach
                </td>
                <td>
                    <!-- Tambahkan tombol aksi di sini (edit, hapus, dll) -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
