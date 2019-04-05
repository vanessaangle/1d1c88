<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $guarded = [];

    public function tempat_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
