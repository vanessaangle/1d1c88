<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desa extends Model
{
    use SoftDeletes;
    
    protected $table = 'desa';

    protected $guarded = [];

    public function tempat_wisata()
    {
        return $this->hasMany(TempatWisata::class);
    }
}
