<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';

    protected $guarded = [];

    public function tempat_wisata()
    {
        return $this->hasMany(TempatWisata::class);
    }
}
