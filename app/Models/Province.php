<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = 'prov_id';
    protected $fillable = ['prov_name', 'locationid', 'status'];

    public function cities()
    {
        return $this->hasMany(City::class, 'prov_id');
    }
}
