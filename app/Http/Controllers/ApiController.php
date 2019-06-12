<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesaWisata;
use App\Atraksi;
use App\Foto;
use App\Video;

class ApiController extends Controller
{
    public function getWisata(Request $request, $cari = null)
    {
        //$cari = $request->cari;
        $desa_wisata = DesaWisata::select('*')
        ->where('desa_wisata.nama_wisata','like',"%$cari%")->get();
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

    public function getAtraksi(Request $request, $filter = null){
        $kegiatan = Atraksi::select('*')
        ->join('desa_wisata','desa_wisata.id','=','atraksi.desa_wisata_id')
        ->where('atraksi.nama_atraksi','like',"%$filter%")->get();
        return response()->json($kegiatan);
    }

    public function getFotoWisata(Request $request, $id_wisata){
        $foto = Foto::where('desa_wisata_id', $id_wisata)->get();
        return response()->json($foto);
    }

    public function getVideoWisata(Request $request, $id_wisata){
        $video = Video::where('desa_wisata_id', $id_wisata)->get();
        return response()->json($video);
    }

    public function getKegiatan(Request $request, $id_wisata){
        $atraksi = Atraksi::select('*')
        ->join('desa_wisata','desa_wisata.id','=','atraksi.desa_wisata_id')
        ->where('atraksi.desa_wisata_id', $id_wisata)->get();
        return response()->json($atraksi);
    }
}
