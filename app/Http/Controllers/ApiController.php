<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desa;
use App\Kegiatan;
use App\Foto;
use App\Video;

class ApiController extends Controller
{
    public function getWisata(Request $request, $cari = null)
    {
        //$cari = $request->cari;
        $desa_wisata = Desa::select('*', 'tempat_wisata.id as tempat_wisata_id')
        ->join('tempat_wisata','tempat_wisata.desa_id','=','desa.id')
        ->where('tempat_wisata.nama_wisata','like',"%$cari%")->get();
        return response()->json($desa_wisata);
    }

    /* public function getWisata()
    {
        return response()->json([
            'wisata' => Desa::with([
                'tempat_wisata.kegiatan',
                'tempat_wisata.foto',
                'tempat_wisata.video',
            ])
            ->get()
        ]);
    } */

    public function getKegiatan(Request $request, $filter = null){
        $kegiatan = Kegiatan::select('*')
        ->join('tempat_wisata','tempat_wisata.id','=','kegiatan.tempat_wisata_id')
        ->where('kegiatan.nama_kegiatan','like',"%$filter%")->get();
        return response()->json($kegiatan);
    }

    public function getFotoWisata(Request $request, $id_wisata){
        $foto = Foto::where('tempat_wisata_id', $id_wisata)->get();
        return response()->json($foto);
    }

    public function getVideoWisata(Request $request, $id_wisata){
        $video = Video::where('tempat_wisata_id', $id_wisata)->get();
        return response()->json($video);
    }
}
