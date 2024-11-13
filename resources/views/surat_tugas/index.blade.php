@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Judul halaman -->
        <h1 class="my-4 text-center" style="font-size: 30px; color: #ffffff; background-color: #007bff; padding: 15px; border-radius: 10px;">DAFTAR SURAT TUGAS</h1>

        <!-- Display success or error messages -->
        @if(session('success'))
            <div class="alert alert-success text-center" style="font-weight: bold; font-size: 18px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center" style="font-weight: bold; font-size: 18px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel untuk menampilkan surat tugas -->
        <div class="table-responsive mt-4" style="border-radius: 10px;">
            <table class="table table-bordered">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Unit</th>
                        <th>Kegiatan</th>
                        <th>Tanggal Asal - Tujuan</th>
                        <th>Belanja dan Beban</th>
                        <th>Laporan</th>
                        <th>View</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratTugas as $index => $surat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $surat->unit }}</td>
                            <td>
                                <span class="badge badge-success">{{ $surat->jenis_pd }}</span>
                                <span class="badge badge-warning">{{ $surat->maksut }}</span>
                                <div>{{ $surat->nama_kegiatan }}</div>
                                <strong>Pelaksana:</strong>
                                <ul>
                                    @foreach($surat->pegawai as $pegawai)
                                        <li>
                                            <span style="{{ $pegawai->has_conflict ? 'color: red;' : '' }}">
                                                {{ $pegawai->nama }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                            </td>
                            <td>
                                @php
                                    $startDate = \Carbon\Carbon::parse($surat->tanggal_kegiatan_mulai);
                                    $endDate = \Carbon\Carbon::parse($surat->tanggal_kegiatan_selesai);
                                @endphp

                                <div>
                                    @if ($startDate->isSameDay($endDate))
                                        {{ $startDate->format('j F Y') }}
                                    @else
                                        {{ $startDate->format('j') }} - {{ $endDate->format('j F Y') }}
                                    @endif
                                </div>
                                <span class="badge badge-info">{{ $surat->asal }} - {{ $surat->tujuan }}</span>
                            </td>
                            <td>Konsumsi, Beban Sewa, Jasa Profesi</td>
                            <td>
                                <span class="badge badge-success">Laporan Foto</span>
                                <button class="btn btn-warning btn-sm mt-2">Edit</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-{{ $surat->id }}">Lihat Surat</button>
                                <button style="background-color: cyan; color: black; margin-bottom: 5px;">PDT</button>
                                <button style="background-color: orange; color: black;">Files</button>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal untuk Surat Tugas -->
                        <div class="modal fade" id="modal-{{ $surat->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $surat->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
                                    <!-- Header Modal -->
                                    <div class="modal-header" style="background-color: #007bff; color: white;">
                                        <h5 class="modal-title" id="modalLabel-{{ $surat->id }}">
                                            Detail Surat Tugas
                                        </h5>
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Body Modal -->
                                    <div class="modal-body" style="padding: 30px;">
                                        <div class="mb-3">
                                            <strong>Unit:</strong> {{ $surat->unit }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Jenis PD:</strong> {{ $surat->jenis_pd }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Maksud:</strong> {{ $surat->maksut }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Nama Kegiatan:</strong> {{ $surat->nama_kegiatan }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Pelaksana:</strong>
                                            <ul>
                                                @foreach($surat->pegawai as $pegawai)
                                                    <li>{{ $pegawai->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="text-center mt-4">
                                            <a href="{{ route('surat_tugas.generateWord', $surat->id) }}" class="btn btn-success btn-lg">
                                                Download Surat Tugas
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Footer Modal -->
                                    <div class="modal-footer" style="background-color: #f8f9fa;">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center font-weight-bold text-danger">Tidak ada data Surat Tugas tersedia.</td>
                        </tr>
                    @endforelse
               
                            </td>
                            <td style="border: 1px solid black;">
                                <button style="background-color: lightgreen; color: black; margin-bottom: 5px;">List SPPD</button>
                                <button style="background-color: pink; color: black; margin-bottom: 5px;">SPD Kolektif</button>
                                <button style="background-color: lightyellow; color: black; margin-bottom: 5px;">SPD All</button>
                                <button style="background-color: lightgray; color: black; margin-bottom: 5px;">Dalam Kota (M)</button>
                            </td>
                            <td style="border: 1px solid black;">
                                <button style="background-color: purple; color: white; margin-bottom: 5px;">Presensi Kegiatan</button>
                                <button style="background-color: red; color: white; margin-bottom: 5px;">Presensi Publik</button>
                                <button style="background-color: teal; color: white; margin-bottom: 5px;">List Dokumen</button>
                                <button style="background-color: blue; color: white; margin-bottom: 5px;">List Presensi</button>
                            </td>
                            <td style="border: 1px solid black;">
                                <button style="background-color: darkred; color: white;">Hapus</button>
                            </td>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
@endsection
