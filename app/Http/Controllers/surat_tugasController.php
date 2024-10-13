<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\pegawai_pd;
use App\Models\Province;
use App\Models\surat_tugas;
use Illuminate\Http\Request;

class surat_tugasController extends Controller
{
    public function create()
    {
        $pegawaiPds = Pegawai_Pd::all(); // Mengambil semua data dari tabel pegawai_pds
        
        return view('surat_tugas.create', compact('pegawaiPds'));
    }

    public function searchCities(Request $request)
    {
        $query = $request->input('q');
    
        $results = Province::join('cities', 'provinces.prov_id', '=', 'cities.prov_id')
            ->where('cities.city_name', 'LIKE', $query . '%')
            ->orWhere('provinces.prov_name', 'LIKE', $query . '%')
            ->orderBy('cities.city_name', 'asc')
            ->select(
                'provinces.prov_name',
                'cities.city_name',
                )
            ->get();
    
        return response()->json($results);
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
        // Validasi input dari form utama
        $validatedData = $request->validate([
            'jenis_pd' => 'required|string',
            'pembayaran' => 'required|string',
            'asal' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_kegiatan_mulai' => 'required|date',
            'tanggal_kegiatan_selesai' => 'required|date',
            'lama_kegiatan' => 'required|integer',
            'pelaksana_ids' => 'required|array', // Menggunakan array ID pelaksana dari modal
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
    
        // Simpan data Surat Tugas
        $suratTugas = new Surat_Tugas();
        $suratTugas->jenis_pd = $validatedData['jenis_pd'];
        $suratTugas->pembayaran = $validatedData['pembayaran'];
        $suratTugas->asal = $validatedData['asal'];
        $suratTugas->tujuan = $validatedData['tujuan'];
        $suratTugas->tanggal_kegiatan_mulai = $validatedData['tanggal_kegiatan_mulai'];
        $suratTugas->tanggal_kegiatan_selesai = $validatedData['tanggal_kegiatan_selesai'];
        $suratTugas->lama_kegiatan = $validatedData['lama_kegiatan'];
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
    
        // Simpan Surat Tugas ke database
        $suratTugas->save();
    
        // Simpan pelaksana ke dalam tabel pivot (relasi many-to-many)
        $suratTugas->pelaksana()->sync($validatedData['pelaksana_ids']);
    
        return redirect()->route('surat_tugas.create')->with('success', 'Surat Tugas berhasil disimpan.');
    }
    
    public function store_pd(Request $request)
    {
 

 // Validasi data dari modal
 $validated = $request->validate([
    'nama' => 'required|string|max:255',
    'nip' => 'required|string|unique:pegawai_pds,nip',
    'jabatan_1' => 'required|string|max:255',
    'golongan' => 'required|string|max:255',
    'status' => 'required|string',
]);

// Simpan data pegawai
$pegawai = Pegawai_Pd::create($validated);

// Kembalikan ID pegawai yang baru disimpan sebagai response
return response()->json(['id' => $pegawai->id]);
    }
}


