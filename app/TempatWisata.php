<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempatWisata extends Model
{
    use SoftDeletes;
    
    protected $table = 'tempat_wisata';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function foto()
    {
        return $this->hasMany(Foto::class);
    }

    public function video()
    {
        return $this->hasMany(Video::class);
    }
}
