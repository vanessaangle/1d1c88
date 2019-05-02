<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desa;
use App\Kegiatan;
use App\Foto;

class ApiController extends Controller
{
    public function getWisata(Request $request)
    {
        $cari = $request->cari;
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

    public function getKegiatan(){
        $kegiatan = Kegiatan::select('*','foto.file as file_foto','video.file as file_video')
        ->join('foto','foto.tempat_wisata_id','=','kegiatan.tempat_wisata_id')
        ->join('video','video.tempat_wisata_id','=','kegiatan.tempat_wisata_id')->get();
        return response()->json($kegiatan);
    }

    public function getFotoWisata(Request $request,$id_wisata){
        $foto = Foto::where('tempat_wisata_id',$id_wisata)->get();
        return response()->json($foto);
    }
}
