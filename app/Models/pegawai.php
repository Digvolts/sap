<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'unit',
        'direktorat',
        'nama',
        'nip',
        'golongan',
        'jabatan',
        'no_handphone',
        'email',
        'npwp',
        'ktp',
        'status',
    ];
}
