<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\pegawai_pd;
use App\Models\Province;
use App\Models\surat_tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class surat_tugasController extends Controller
{
    public function index()
    {
        $suratTugas = Surat_Tugas::with('pegawaiPds')->get();
        return view('surat_tugas.index', compact('suratTugas'));
    }
    
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
        $validated = $request->validate([
            'unit' => 'required|string|max:255',
            'jenis_pd' => 'required|string',
            'jenis_pd_2' => 'required|string',
            'kurs' => 'nullable|string|max:255',
            'asal' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'tanggal_kegiatan_mulai' => 'required|date_format:d-m-Y',
            'tanggal_kegiatan_selesai' => 'required|date_format:d-m-Y',
            'lama_kegiatan' => 'required|integer',
            'maksut' => 'required|string|max:255',
            'meeting_online' => 'required|boolean',
            'nama_kegiatan' => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer',
            'dasar' => 'required|string',
            'lampiran' => 'nullable|string|max:255',
            'is_draft' => 'required|boolean',
            'catatan' => 'nullable|string',
            'pegawai_ids' => 'required|array',
        ]);

        // Convert dates to Y-m-d format for database storage
        $validated['tanggal_kegiatan_mulai'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_kegiatan_mulai'])->format('Y-m-d');
        $validated['tanggal_kegiatan_selesai'] = Carbon::createFromFormat('d-m-Y', $validated['tanggal_kegiatan_selesai'])->format('Y-m-d');

        $suratTugas = Surat_Tugas::create($validated);
        $suratTugas->pegawaiPds()->sync($validated['pegawai_ids']);
       
        return redirect()->route('surat_tugas.index')->with('success', 'Surat Tugas berhasil disimpan.');
    }
    
    
    public function store_pd(Request $request)
    {
         // Validasi data dari modal
         $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:pegawai_pds,nip',
            'jabatan_1' => 'required|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'status' => 'nullable|string',
        ]);
        
        // Simpan data pegawai
        $pegawai = Pegawai_Pd::create($validated);
        
        // Kembalikan ID pegawai yang baru disimpan sebagai response
        
        return response()->json([
            'success' => true, 
            'id' => $pegawai->id,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'jabatan_1' => $pegawai->jabatan_1,
            'golongan' => $pegawai->golongan,
            'status' => $pegawai->status
        ]);

    }
}


