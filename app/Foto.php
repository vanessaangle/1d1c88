<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use SoftDeletes;
    
    protected $table = 'foto';

    protected $guarded = [];

    public function desa_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
