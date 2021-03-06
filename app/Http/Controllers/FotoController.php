<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Desa;
use Carbon\Carbon;
use App\Helpers\Alert;
use App\Foto;
use App\Helpers\AppHelper;

class FotoController extends Controller
{
    private $template = [
        'title' => 'Foto',
        'route' => 'admin.tempat_wisata.foto',
        'menu' => 'tempat_wisata',
        'icon' => 'fa fa-map',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            ['label' => 'File Foto', 'name' => 'file_foto', 'type' => 'file']
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
        $data = Foto::where('desa_wisata_id',$tempat_wisata_id)->get();
        return view('admin.foto.index',compact('template','data','tempat_wisata_id'));
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
        return view('admin.foto.create',compact('template','form','tempat_wisata_id'));
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
            'file_foto' => 'required',
        ]);
        $uploaded = AppHelper::uploader($this->form(),$request);
        $data['desa_wisata_id'] = $tempat_wisata_id;
        $data['file'] = $uploaded['file_foto'];
        Foto::create($data);
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tempat,$id)
    {
       
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($te,$id)
    {
        Foto::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
