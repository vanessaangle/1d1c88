<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atraksi extends Model
{
    use SoftDeletes;
    
    protected $table = 'kegiatan';

    protected $guarded = [];

    public function desa_wisata()
    {
        return $this->belongsTo(DesaWisata::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'kategori_id');
    }
}
