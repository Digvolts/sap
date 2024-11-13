<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat_tugas_pegawais extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_tugas_id', 'nama', 'nip', 'jabatan', 'golongan', 'status', 'pelaksana', 'keterangan',
        'tanggal_kegiatan_mulai', 'tanggal_kegiatan_selesai'
    ];

    public function suratTugas()
    {
        return $this->belongsTo(Surat_Tugas::class);
    }
}
