<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';

    protected $guarded = [];

    public function tempat_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
