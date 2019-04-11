<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use SoftDeletes;
    
    protected $table = 'kegiatan';

    protected $guarded = [];

    public function tempat_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
