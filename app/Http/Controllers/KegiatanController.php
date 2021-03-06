<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desa;
use Carbon\Carbon;
use App\Helpers\Alert;
use App\Atraksi as Kegiatan;
use App\Helpers\AppHelper;

class KegiatanController extends Controller
{
    private $template = [
        'title' => 'Kegiatan',
        'route' => 'admin.tempat_wisata.kegiatan',
        'menu' => 'tempat_wisata',
        'icon' => 'fa fa-map',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            ['label' => 'Nama Atraksi', 'name' => 'nama_atraksi'],
            ['label' => 'Deskripsi', 'name' => 'deskripsi', 'type' => 'ckeditor'],
            ['label' => 'Foto' , 'name' => 'foto','type' => 'file','required' => ['create']]
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tempat_wisata_id)
    {
        $template = (object) $this->template;
        $data = Kegiatan::where('desa_wisata_id',$tempat_wisata_id)->get();
        return view('admin.kegiatan.index',compact('template','data','tempat_wisata_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tempat_wisata_id)
    {
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.kegiatan.create',compact('template','form','tempat_wisata_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$tempat_wisata_id)
    {
        $request->validate([
            'nama_atraksi' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required'
        ]);
        $uploaded = AppHelper::uploader($this->form(),$request);
        $data = $request->all();
        $data['desa_wisata_id'] = $tempat_wisata_id;
        $data['foto'] = $uploaded['foto'];
        Kegiatan::create($data);
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index',[$tempat_wisata_id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tempat_wisata_id,$id)
    {
        $template = (object)$this->template;
        $data = Kegiatan::findOrFail($id);
        return view('admin.kegiatan.show',compact('template','data','tempat_wisata_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tempat,$id)
    {
        $data = Kegiatan::findOrFail($id);
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.kegiatan.edit',compact('template','form','data','tempat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$tempat,$id)
    {
        $request->validate([
            'nama_atraksi' => 'required',
            'deskripsi' => 'required',
        ]);
        $data = $request->all();
        if($request->hasFile('foto')){
            $uploaded = AppHelper::uploader($this->form(),$request);
            $data['foto'] = $uploaded['foto'];
        }else{
            unset($data['foto']);
        }
        Kegiatan::find($id)->update($data);
        Alert::make('success','Berhasil mengubah data');
        return redirect(route($this->template['route'].'.index',[$tempat]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($te,$id)
    {
        Kegiatan::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
