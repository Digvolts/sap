<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\Province;
use App\Models\surat_tugas;
use Illuminate\Http\Request;

class surat_tugasController extends Controller
{
    public function create()
    {
        return view('surat_tugas.create');
    }

    public function searchCities(Request $request)
    {
        $query = $request->input('q');
        $cities = Province::join('cities', 'provinces.prov_id', '=', 'cities.prov_id')
            ->where('cities.city_name', 'LIKE', $query . '%') // Menggunakan pola pencarian yang cocok dengan huruf depan
            ->orderBy('cities.city_name', 'asc')
            ->select('cities.city_name', 'provinces.prov_name')
            ->get();
    
        return response()->json($cities);
    }
    public function getSuggestions(Request $request)
    {
        $query = $request->input('query');
        
        // Assuming you have a model named Employee to fetch names
        $suggestions = pegawai::where('nama', 'LIKE', "%{$query}%")->get();
    
        return response()->json($suggestions);
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
