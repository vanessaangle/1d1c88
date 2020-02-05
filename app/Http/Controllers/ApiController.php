<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesaWisata;
use App\Atraksi;
use App\Kegiatan;
use App\Foto;
use App\Video;
use App\Kategori;
use App\Event;
use App\CalendarEvent;

class ApiController extends Controller
{
    public function getWisata(Request $request, $cari = null)
    {
        $desa_wisata = DesaWisata::select('*')
        ->where('desa_wisata.nama_wisata','like',"%$cari%")->get();
        return response()->json($desa_wisata);
    }

    public function getFotoWisata(Request $request, $id_wisata){
        $foto = Foto::where('desa_wisata_id', $id_wisata)->get();
        return response()->json($foto);
    }

    public function getVideoWisata(Request $request, $id_wisata){
        $video = Video::where('desa_wisata_id', $id_wisata)->get();
        return response()->json($video);
    }

    public function getKategori(Request $request){
        $foto = Kategori::all();
        return response()->json($foto);
    }

    public function getKegiatan(Request $request, $nama_kategori = null){
        if ($nama_kategori != null){
            $atraksi = Atraksi::select('*')
            ->join('desa_wisata','desa_wisata.id','=','kegiatan.desa_wisata_id')
            ->join('kategori','kategori.id','=','kegiatan.kategori_id')
            ->where('kategori.nama_kategori',$nama_kategori)->get();
        } else {
            $atraksi = Atraksi::select('*')
            ->join('desa_wisata','desa_wisata.id','=','kegiatan.desa_wisata_id')
            ->join('kategori','kategori.id','=','kegiatan.kategori_id')->get();
        }

        return response()->json($atraksi);
    }

    public function getEvent(Request $request, $status = null){
        if ($status != null){
            $event = CalendarEvent::select('*')
            ->where('event.status', $status)->get();
        } else {
            $event = CalendarEvent::select('*')->get();
        }

        return response()->json($event);
    }
}
