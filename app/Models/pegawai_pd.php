<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai_pd extends Model
{
    protected $table = 'pegawai_pds';
    protected $fillable = ['nama', 'nip', 'jabatan_1', 'golongan', 'status'];

    public function suratTugas()
    {
        return $this->belongsToMany(Surat_Tugas::class, 'surat_tugas_pegawai', 'pegawai_pd_id', 'surat_tugas_id');
    }
}
