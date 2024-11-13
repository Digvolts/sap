<?php

namespace App\Http\Controllers;

use App\Models\pegawai;
use App\Models\Province;
use App\Models\surat_tugas;
use App\Models\surat_tugas_pegawais;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\TemplateProcessor;

class surat_tugasController extends Controller
{
    public function index()
    {
        // Ambil semua surat tugas beserta pegawai
        $suratTugas = surat_tugas::with('pegawai')->get();
    
        // Loop melalui setiap pegawai di setiap surat tugas untuk pengecekan bentrok
        foreach ($suratTugas as $surat) {
            foreach ($surat->pegawai as $pegawai) {
                // Cek apakah ada pegawai dengan nama dan tanggal bentrok
                $hasConflict = surat_tugas_pegawais::where('nama', $pegawai->nama)
                    ->where('surat_tugas_id', '!=', $surat->id) // Pastikan bukan dari surat tugas yang sama
                    ->where(function ($query) use ($surat) {
                        $query->whereBetween('tanggal_kegiatan_mulai', [$surat->tanggal_kegiatan_mulai, $surat->tanggal_kegiatan_selesai])
                              ->orWhereBetween('tanggal_kegiatan_selesai', [$surat->tanggal_kegiatan_mulai, $surat->tanggal_kegiatan_selesai]);
                    })
                    ->exists();
    
                // Tambahkan atribut `has_conflict` jika ada bentrok
                $pegawai->has_conflict = $hasConflict;
            }
        }
    
        return view('surat_tugas.index', compact('suratTugas'));
    }
    
    
    public function create()
    {
            // Mengambil daftar pegawai dari session jika ada
            $pegawaiList = session()->get('pegawai_list', []);
            return view('surat_tugas.create', compact('pegawaiList'));
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
    
    public function store(Request $request) {
        Log::info('Starting store method');
        $validatedData = $request->validate([
            'unit' => 'required',
            'jenis_pd' => 'nullable',
            'jenis_pd_2' => 'nullable',
            'asal' => 'nullable',
            'tujuan' => 'required',
            'tanggal_kegiatan_mulai' => 'required|date',
            'tanggal_kegiatan_selesai' => 'required|date|after_or_equal:tanggal_kegiatan_mulai',
            'lama_kegiatan' => 'nullable|integer|min:1',
            'maksut' => 'nullable',
            'meeting_online' => 'nullable|boolean',
            'nama_kegiatan' => 'required',
            'jumlah_peserta' => 'nullable|integer|min:1',
            'dasar' => 'required',
            'lampiran' => 'nullable|file',
            'is_draft' => 'required|boolean',
            'catatan' => 'nullable'
        ]);
    // Convert dates to `Y-m-d` format
    $validatedData['tanggal_kegiatan_mulai'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_kegiatan_mulai'])->format('Y-m-d');
    $validatedData['tanggal_kegiatan_selesai'] = Carbon::createFromFormat('d-m-Y', $validatedData['tanggal_kegiatan_selesai'])->format('Y-m-d');
        try {
            DB::transaction(function () use ($validatedData, $request) {
                Log::info('Inside transaction');
                if ($request->hasFile('lampiran')) {
                    $path = $request->file('lampiran')->store('lampiran');
                    $validatedData['lampiran'] = $path;
                }
        
                // Save surat tugas
                $suratTugas = surat_tugas::create($validatedData);
        
                // Store related pegawai records
                $pegawaiList = session()->get('pegawai_list', []);
                    foreach ($pegawaiList as $pegawai) {
                        surat_tugas_pegawais::create([
                            'surat_tugas_id' => $suratTugas->id,
                            'nama' => $pegawai['nama'],
                            'nip' => $pegawai['nip'],
                            'jabatan' => $pegawai['jabatan'],
                            'golongan' => $pegawai['golongan'],
                            'status' => $pegawai['status'],
                            'pelaksana' => $pegawai['pelaksana'],         // Added pelaksana
                            'keterangan' => $pegawai['keterangan'] ?? '', // Added keterangan with a default of empty string if not present
                            'tanggal_kegiatan_mulai' => $validatedData['tanggal_kegiatan_mulai'],
                            'tanggal_kegiatan_selesai' => $validatedData['tanggal_kegiatan_selesai']
                        ]);
                    }
        
                // Clear pegawai from session
                session()->forget('pegawai_list');
            });
        
            return redirect()->route('surat_tugas.index')
                ->with('success', 'Surat Tugas berhasil dibuat.');
        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
        
    }
    
    public function storePegawai(Request $request)
{
    $validatedData = $request->validate([
        'pegawai' => 'required|array|min:1',
        'pegawai.*.nama' => 'required|string',
        'pegawai.*.nip' => 'required|string',
        'pegawai.*.jabatan' => 'required|string',
        'pegawai.*.golongan' => 'required|string',
        'pegawai.*.status' => 'required|string',
        'pegawai.*.pelaksana' => 'required|string',  // Add validation for pelaksana
        'pegawai.*.keterangan' => 'nullable|string',  // Add validation for keterangan (optional field)
        'tanggal_kegiatan_mulai' => 'required|date',
        'tanggal_kegiatan_selesai' => 'required|date|after_or_equal:tanggal_kegiatan_mulai',
    ]);

    // Store the date in the session
    session()->put('tanggal_kegiatan_mulai', $validatedData['tanggal_kegiatan_mulai']);
    session()->put('tanggal_kegiatan_selesai', $validatedData['tanggal_kegiatan_selesai']);
    
    // Add employees to the session
    $pegawaiList = session()->get('pegawai_list', []);
    foreach ($validatedData['pegawai'] as $pegawai) {
        // Add date data to each employee
        $pegawai['tanggal_kegiatan_mulai'] = $validatedData['tanggal_kegiatan_mulai'];
        $pegawai['tanggal_kegiatan_selesai'] = $validatedData['tanggal_kegiatan_selesai'];
        
        // Add the employee to the list
        $pegawaiList[] = $pegawai;
    }
    
    // Update session with the new list of employees
    session()->put('pegawai_list', $pegawaiList);
    
    return redirect()->route('surat_tugas.create')
        ->with('success', 'Pegawai berhasil ditambahkan ke form.');
}

    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'unit' => 'required',
            'jenis_pd' => 'required',
            'asal' => 'required',
            'tujuan' => 'required',
            'tanggal_kegiatan_mulai' => 'required|date',
            'tanggal_kegiatan_selesai' => 'required|date|after_or_equal:tanggal_kegiatan_mulai',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $id) {
                $suratTugas = Surat_Tugas::findOrFail($id);
                $suratTugas->update($validatedData);
            });

            return redirect()->route('surat_tugas.index')
                ->with('success', 'Surat Tugas berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $suratTugas = Surat_Tugas::findOrFail($id);
                $suratTugas->delete();
            });

            return redirect()->route('surat_tugas.index')
                ->with('success', 'Surat Tugas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generateWord($id)
    {
        // Ambil data Surat Tugas beserta pegawai
        $suratTugas = Surat_Tugas::with('pegawai')->findOrFail($id);
    
        // Pilih template berdasarkan jumlah pegawai
        $templatePath = $suratTugas->pegawai->count() == 1 
            ? public_path('ST_word.docx') 
            : public_path('STmulti.docx');
        
        // Validasi template tersedia
        if (!file_exists($templatePath)) {
            abort(404, 'Template file not found.');
        }
    
      // Initialize Template Processor
    $templateProcessor = new TemplateProcessor($templatePath);

    // Fill general placeholders (always done for both templates)
    $this->fillGeneralPlaceholders($templateProcessor, $suratTugas);

    // Fill employee data based on the template
    if ($suratTugas->pegawai->count() == 1) {
        // For single employee (ST_word.docx), use a simple foreach loop to fill placeholders
        $this->fillSingleEmployeeData($templateProcessor, $suratTugas->pegawai->first());
    } else {
        // For multiple employees (STmulti.docx), use fillEmployeeTables method
        $this->fillEmployeeTables($templateProcessor, $suratTugas);
    }

    // Save and download the document
    return $this->saveAndDownloadDocument($templateProcessor, $suratTugas);
}
    
private function fillSingleEmployeeData(TemplateProcessor $templateProcessor, $pegawai)
{
    // Fill placeholders with employee details for a single employee template
    $templateProcessor->setValue('pegawai.nama', $pegawai->nama ?? 'N/A');
    $templateProcessor->setValue('pegawai.NIP', $pegawai->nip ?? 'N/A');
    $templateProcessor->setValue('pegawai.golongan', $pegawai->golongan ?? 'N/A');
    $templateProcessor->setValue('pegawai.jabatan', $pegawai->jabatan ?? 'N/A');
}


    private function fillGeneralPlaceholders(TemplateProcessor $templateProcessor, $suratTugas)
    {
        // Placeholder umum surat tugas
        $templateProcessor->setValue('noSurat', $suratTugas->id);
        $templateProcessor->setValue('createAt', $suratTugas->created_at->format('d F Y'));
        $templateProcessor->setValue('tglKeg', $suratTugas->created_at->format('n/Y'));
        $templateProcessor->setValue('namaKegiatan', $suratTugas->nama_kegiatan);
        $templateProcessor->setValue('dasar', $suratTugas->dasar);
        $templateProcessor->setValue('startDate', \Carbon\Carbon::parse($suratTugas->tanggal_kegiatan_mulai)->format('j'));
        $templateProcessor->setValue('endDate', \Carbon\Carbon::parse($suratTugas->tanggal_kegiatan_selesai)->format('j F Y'));
        $templateProcessor->setValue('asal', $suratTugas->asal);
        $templateProcessor->setValue('tujuan', $suratTugas->tujuan);
        $templateProcessor->setValue('peserta', $suratTugas->pegawai->count());
    }
    
    private function fillEmployeeTables(TemplateProcessor $templateProcessor, $suratTugas)
    {
        // Pastikan ada pegawai
        if ($suratTugas->pegawai->isEmpty()) {
            return;
        }
    
        // Clone baris untuk setiap tabel
        $templateProcessor->cloneRow('no1', $suratTugas->pegawai->count());
        $templateProcessor->cloneRow('no2', $suratTugas->pegawai->count());
        $templateProcessor->cloneRow('no3', $suratTugas->pegawai->count());
    
        // Isi data pegawai untuk setiap tabel
        foreach ($suratTugas->pegawai as $index => $pegawai) {
            // Tabel 1
            $templateProcessor->setValue("no1#" . ($index + 1), $index + 1);
            $templateProcessor->setValue("nama1#" . ($index + 1), $pegawai->nama ?? 'N/A');
            $templateProcessor->setValue("NIP1#" . ($index + 1), $pegawai->nip ?? 'N/A');
            $templateProcessor->setValue("golongan1#" . ($index + 1), $pegawai->golongan ?? 'N/A');
            $templateProcessor->setValue("jabatan1#" . ($index + 1), $pegawai->jabatan ?? 'N/A');
    
            // Tabel 2
            $templateProcessor->setValue("no2#" . ($index + 1), $index + 1);
            $templateProcessor->setValue("nama2#" . ($index + 1), $pegawai->nama ?? 'N/A');
            $templateProcessor->setValue("NIP2#" . ($index + 1), $pegawai->nip ?? 'N/A');
            $templateProcessor->setValue("golongan2#" . ($index + 1), $pegawai->golongan ?? 'N/A');
            $templateProcessor->setValue("jabatan2#" . ($index + 1), $pegawai->jabatan ?? 'N/A');
    
            // Tabel 3
            $templateProcessor->setValue("no3#" . ($index + 1), $index + 1);
            $templateProcessor->setValue("nama3#" . ($index + 1), $pegawai->nama ?? 'N/A');
            $templateProcessor->setValue("NIP3#" . ($index + 1), $pegawai->nip ?? 'N/A');
            $templateProcessor->setValue("golongan3#" . ($index + 1), $pegawai->golongan ?? 'N/A');
            $templateProcessor->setValue("jabatan3#" . ($index + 1), $pegawai->jabatan ?? 'N/A');
        }
    }
    
    private function saveAndDownloadDocument(TemplateProcessor $templateProcessor, $suratTugas)
    {
        // Buat nama file
        $fileName = "Surat_Tugas_{$suratTugas->id}.docx";
        
        // Tentukan path penyimpanan
        $filePath = storage_path("app/public/{$fileName}");
    
        // Simpan file
        $templateProcessor->saveAs($filePath);
    
        // Unduh dan hapus file setelah diunduh
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}


