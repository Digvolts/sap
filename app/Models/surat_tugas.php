<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat_tugas extends Model
{
    use HasFactory;
    
   protected $fillable = [
        'unit', 'jenis_pd', 'jenis_pd_2', 'asal', 'tujuan', 'tanggal_kegiatan_mulai',
        'tanggal_kegiatan_selesai', 'lama_kegiatan', 'maksut', 'meeting_online',
        'nama_kegiatan', 'jumlah_peserta', 'dasar', 'lampiran', 'is_draft', 'catatan'
    ];
    public function pegawai()
    {
        return $this->hasMany(surat_tugas_pegawais::class);
    }
}
