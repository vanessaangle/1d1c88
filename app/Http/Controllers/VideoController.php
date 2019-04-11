<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desa;
use Carbon\Carbon;
use App\Helpers\Alert;
use App\Video;
use App\Helpers\AppHelper;

class VideoController extends Controller
{
    private $template = [
        'title' => 'Video',
        'route' => 'admin.tempat_wisata.video',
        'menu' => 'tempat_wisata',
        'icon' => 'fa fa-map',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            ['label' => 'Url Video', 'name' => 'link']
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
        $data = Video::where('tempat_wisata_id',$tempat_wisata_id)->get();
        return view('admin.video.index',compact('template','data','tempat_wisata_id'));
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
        return view('admin.video.create',compact('template','form','tempat_wisata_id'));
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
            'link' => 'required',
        ]);
        $uploaded = AppHelper::uploader($this->form(),$request);
        Video::create([
            'file' => $request->link,
            'tempat_wisata_id' => $tempat_wisata_id
        ]);
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
        return view('admin.kegiatan.edit',compact('template','form','data'));
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
            'nama_desa' => 'required',
            'status' => 'required',
        ]);
        $data = $request->all();
        Desa::find($id)->update($data);
        Alert::make('success','Berhasil mengubah data');
        return redirect(route($this->template['route'].'.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($te,$id)
    {
        Video::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
