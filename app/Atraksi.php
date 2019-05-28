<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atraksi extends Model
{
    use SoftDeletes;
    
    protected $table = 'atraksi';

    protected $guarded = [];

    public function desa_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
