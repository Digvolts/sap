<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'city_id';
    protected $fillable = ['city_name', 'prov_id'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'prov_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'city_id');
    }
}
