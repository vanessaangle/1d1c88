<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesaWisata;
use App\Desa;
use Carbon\Carbon;
use App\Helpers\Alert;
use App\Helpers\AppHelper;

class DesaWisataController extends Controller
{
    private $template = [
        'title' => 'Desa Wisata',
        'route' => 'admin.desa-wisata',
        'menu' => 'tempat_wisata',
        'icon' => 'fa fa-users',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            ['label' => 'Nama Wisata', 'name' => 'nama_wisata','view_index' => true],
            ['label' => 'Alamat Wisata', 'name' => 'alamat_wisata', 'type' => 'textarea','view_index' => true],
            ['label' => 'Sejarah','name' => 'sejarah_desa', 'type' => 'ckeditor','view_index' => true],
            ['label' => 'Demografi','name' => 'demografi', 'type' => 'ckeditor'],
            ['label' => 'Potensi','name' => 'potensi', 'type' => 'ckeditor'],
            ['label' => 'Thumbnail', 'name' => 'thumbnail','type' => 'file','required' => ['create']],
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
        $data = DesaWisata::all();
        $form = $this->form();
        return view('admin.master.index',compact('template','data','form'));
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
        return view('admin.master.create',compact('template','form'));
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
            'alamat_wisata' => 'required',
            'sejarah_desa' => 'required',
            'demografi' => 'required',
            'potensi' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'thumbnail' => 'required|mimes:png,jpg,jpeg'
            
        ]);
        $data = $request->all();
        $uploader = AppHelper::uploader($this->form(),$request);
        $data['user_id'] = auth()->user()->id;
        $data['thumbnail'] =  $uploader['thumbnail'];
        DesaWisata::create($data);
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
        $data = DesaWisata::findOrFail($id);
        $form = $this->form();
        return view('admin.master.show',compact('template','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DesaWisata::findOrFail($id);
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.master.edit',compact('template','form','data'));
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
            'alamat_wisata' => 'required',
            'sejarah_desa' => 'required',
            'demografi' => 'required',
            'potensi' => 'required',
            'lat' => 'required',
            'lng' => 'required'
        ]);
        $wisata = DesaWisata::find($id);
        $data = $request->all();
        $data['thumbnail'] = $wisata->thumbnail;
        if($request->hasFile('thumbnail')){
            $uploader = AppHelper::uploader($this->form(),$request);
            $data['thumbnail'] = $uploader['thumbnail'];
        }
        $wisata->update($data);
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
        DesaWisata::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
