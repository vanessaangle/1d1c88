<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desa;

class ApiController extends Controller
{
    public function getWisata()
    {
        return response()->json([
            'wisata' => Desa::with([
                'tempat_wisata.kegiatan',
                'tempat_wisata.foto',
                'tempat_wisata.video',
            ])
            ->get()
        ]);
    }
}
