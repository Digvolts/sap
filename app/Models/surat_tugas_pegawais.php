<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat_tugas_pegawais extends Model
{
    protected $table = 'surat_tugas_pegawais';

    // Jika Anda ingin timestamps (created_at dan updated_at) diisi otomatis
    public $timestamps = true;

    // Jika Anda ingin mengizinkan mass assignment untuk semua kolom
    protected $guarded = [];

    // Atau jika Anda ingin menentukan kolom mana yang bisa di-assign secara massal
    // protected $fillable = ['surat_tugas_id', 'pegawai_pd_id'];

    public function suratTugas()
    {
        return $this->belongsTo(Surat_Tugas::class);
    }

    public function pegawaiPd()
    {
        return $this->belongsTo(Pegawai_Pd::class);
    }
}
