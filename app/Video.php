<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';

    protected $guarded = [];

    public function tempat_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
