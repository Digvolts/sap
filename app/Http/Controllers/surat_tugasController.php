<?php

namespace App\Http\Controllers;

use App\Models\surat_tugas;
use Illuminate\Http\Request;

class surat_tugasController extends Controller
{
    public function create()
    {
        return view('surat_tugas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_pd' => 'required|string',
            'pembayaran' => 'required|string',
            'asal' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_kegiatan_mulai' => 'required|date',
            'tanggal_kegiatan_selesai' => 'required|date',
            'lama_kegiatan' => 'required|integer',
            'pelaksana' => 'required|string',
            'maksut' => 'required|string',
            'meeting_online' => 'boolean',
            'nama_kegiatan' => 'required|string',
            'jumlah_peserta' => 'required|integer',
            'dasar' => 'required|string',
            'detail_jadwal' => 'required|string',
            'penandatanganan' => 'required|string',
            'lampiran' => 'nullable|string',
            'is_draft' => 'boolean',
            'catatan' => 'nullable|string',
        ]);
    
        $suratTugas = new surat_tugas();
        $suratTugas->jenis_pd = $validatedData['jenis_pd'];
        $suratTugas->asal = $validatedData['asal'];
        $suratTugas->tujuan = $validatedData['tujuan'];
        $suratTugas->tanggal_kegiatan_mulai = $validatedData['tanggal_kegiatan_mulai'];
        $suratTugas->tanggal_kegiatan_selesai = $validatedData['tanggal_kegiatan_selesai'];
        $suratTugas->lama_kegiatan = $validatedData['lama_kegiatan'];
        $suratTugas->pelaksana = $validatedData['pelaksana'];
        $suratTugas->maksut = $validatedData['maksut'];
        $suratTugas->meeting_online = $validatedData['meeting_online'];
        $suratTugas->nama_kegiatan = $validatedData['nama_kegiatan'];
        $suratTugas->jumlah_peserta = $validatedData['jumlah_peserta'];
        $suratTugas->dasar = $validatedData['dasar'];
        $suratTugas->detail_jadwal = $validatedData['detail_jadwal'];
        $suratTugas->penandatanganan = $validatedData['penandatanganan'];
        $suratTugas->lampiran = $validatedData['lampiran'];
        $suratTugas->is_draft = $validatedData['is_draft'];
        $suratTugas->catatan = $validatedData['catatan'];
    
        $suratTugas->save();
    
        return redirect()->route('surat_tugas.create')->with('success', 'Surat Tugas berhasil disimpan.');
    }
    
}
