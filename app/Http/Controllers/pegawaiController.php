<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use Illuminate\Http\Request;

class pegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 10); // Default to 10 if not set
    
        $pegawais = Pegawai::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                         ->orWhere('nip', 'like', '%' . $search . '%');
        })->paginate($perPage);
    
        return view('pegawai.index', compact('pegawais', 'search'));
    }
    
    public function getData(Request $request)
{
    // Get the search query
    $search = $request->get('search');
    $perPage = $request->get('per_page', 10); // Default to 10 if not set

    // Fetch the pegawai data with search
    $pegawais = Pegawai::when($search, function ($query, $search) {
        return $query->where('nama', 'like', '%' . $search . '%')
                     ->orWhere('nip', 'like', '%' . $search . '%');
    })->paginate($perPage);

    return response()->json($pegawais);
}


    public function create()
    {
        return view('pegawai.create');
    }
            
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'unit' => 'nullable|string|max:255',
            'direktorat' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|min:20|unique:pegawais',
            'golongan' => 'nullable|string',
            'jabatan' => 'required|string', // Required field
            'no_handphone' => 'nullable|string',
            'email' => 'nullable|email',
            'npwp' => 'nullable|string|size:20|unique:pegawais',
            'ktp' => 'nullable|string|size:16|unique:pegawais',
            'status' => 'nullable|string',
        ]);
    
        // Create a new Pegawai record
        Pegawai::create($validatedData);
        
        return redirect()->route('pegawai.index')->with('success', 'Pegawai baru berhasil ditambahkan!');
    }
    
    
    

    public function edit(Pegawai $pegawai)
    {
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'string|min:20|unique:pegawais',
            'golongan' => 'string',
            'jabatan' => 'required|string',
            'no_handphone' => 'string',
            'email' => 'email',
            'npwp' => 'string|size:15|unique:pegawais', // 15 characters for NPWP
            'ktp' => 'string|size:16|unique:pegawais', // 16 characters for KTP
            'status' => '|string',
        ]);

        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }

}
