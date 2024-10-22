@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Surat Tugas</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
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
            @if($suratTugas->count() > 0)
                @foreach($suratTugas as $index => $surat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $surat->unit }}</td>
                        <td>{{ $surat->nama_kegiatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_kegiatan_mulai)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_kegiatan_selesai)->format('d-m-Y') }}</td>
                        <td>
                            @foreach($surat->pegawaiPds as $pegawai)
                                {{ $pegawai->nama }}<br>
                            @endforeach
                        </td>
                        <td>
                       
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">Belum ada surat tugas yang tersedia</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
