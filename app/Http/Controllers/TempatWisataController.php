<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TempatWisata;
use App\Desa;
use Carbon\Carbon;
use App\Helpers\Alert;

class TempatWisataController extends Controller
{
    private $template = [
        'title' => 'Tempat Wisata',
        'route' => 'admin.tempat-wisata',
        'menu' => 'tempat_wisata',
        'icon' => 'fa fa-users',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        $desa = Desa::select('id as value','nama_desa as name')
            ->get();
        return [
            ['label' => 'Nama Wisata', 'name' => 'nama_wisata'],
            ['label' => 'Desa','name' => 'desa_id','type' => 'select', 'option' => $desa],
            ['label' => 'Alamat Wisata', 'name' => 'alamat_wisata', 'type' => 'textarea'],
            ['label' => 'Sejarah','name' => 'sejarah_wisata', 'type' => 'ckeditor'],
            ['label' => 'Demografi','name' => 'demografi', 'type' => 'ckeditor'],
            ['label' => 'Potensi','name' => 'potensi', 'type' => 'ckeditor'],
            ['label' => 'Lokasi','type' => 'map'],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = (object) $this->template;
        $data = TempatWisata::all();
        return view('admin.tempat_wisata.index',compact('template','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.tempat_wisata.create',compact('template','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_wisata' => 'required',
            'desa_id' => 'required|exists:desa,id',
            'alamat_wisata' => 'required',
            'sejarah_wisata' => 'required',
            'demografi' => 'required',
            'potensi' => 'required',
            'lat' => 'required',
            'lng' => 'required'
            
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        TempatWisata::create($data);
        Alert::make('success','Berhasil  simpan data');
        return redirect(route($this->template['route'].'.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $template = (object)$this->template;
        $data = TempatWisata::findOrFail($id);
        return view('admin.tempat_wisata.show',compact('template','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TempatWisata::findOrFail($id);
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.tempat_wisata.edit',compact('template','form','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_wisata' => 'required',
            'desa_id' => 'required|exists:desa,id',
            'alamat_wisata' => 'required',
            'sejarah_wisata' => 'required',
            'demografi' => 'required',
            'potensi' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);
        $data = $request->all();
        TempatWisata::find($id)->update($data);
        Alert::make('success','Berhasil mengubah data');
        return redirect(route($this->template['route'].'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TempatWisata::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
