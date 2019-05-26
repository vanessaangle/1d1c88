<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    
    protected $table = 'video';

    protected $guarded = [];

    public function desa_wisata()
    {
        return $this->belongsTo(TempatWisata::class);
    }
}
