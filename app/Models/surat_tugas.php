<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat_tugas extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_pd',
        'asal',
        'tujuan',
        'tanggal_kegiatan_mulai',
        'tanggal_kegiatan_selesai',
        'lama_kegiatan',
        'pelaksana',
        'maksut',
        'meeting_online',
        'nama_kegiatan',
        'jumlah_peserta',
        'dasar',
        'detail_jadwal',
        'penandatanganan',
        'lampiran',
        'is_draft',
        'catatan',
    ];
    public function pelaksana()
    {
        return $this->belongsToMany(Pegawai_Pd::class, 'surat_tugas_pegawai', 'surat_tugas_id', 'pegawai_pd_id');
    }
}
