<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AtraksiFile;
use App\Helpers\AppHelper;
use App\Helpers\Alert;

class AtraksiFileController extends Controller
{
    private $template = [
        'title' => 'Atraksi File',
        'route' => 'admin.file',
        'menu' => 'tempat_wisata',
        'icon' => 'fa fa-map',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        $types = [
            [
                'value' => 'Foto','name' => 'Foto'
            ],
            [
                'value' => 'Video','name' => 'Video'
               
            ],
            [
                'value' => 'Dokumen','name' => 'Dokumen'
            ]
        ];
        return [
            ['label' => 'Tipe File', 'name' => 'tipe', 'type' => 'select','option' => $types, 'view_index' => true],
            ['label' => 'File','name' => 'file','type' => 'file','required' => ['create'], 'view_index' => true],
            ['label' => 'Judul File','name' => 'judul', 'view_index' => true ,'required' => []]
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($desa_wisata_id,$atraksi_id)
    {
        $template = (object) $this->template;
        $data = AtraksiFile::where('atraksi_id',$atraksi_id)->get();
        return view('admin.file.index',compact('template','data','desa_wisata_id','atraksi_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($desa_wisata_id,$atraksi_id)
    {
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.file.create',compact('template','form','desa_wisata_id','atraksi_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$desa_wisata_id,$atraksi_id)
    {
        $request->validate([
            'file' => 'required',
            'tipe' => 'required'
        ]);
        switch ($request->tipe) {
            case 'Foto':
                $request->validate([
                    'file' => 'mimes:jpg,png,jpeg'
                ]);
                break;
            case 'Video':
                $request->validate([
                    'file' => 'mimes:mp4,3gp,avi'
                ]);
                break;
            case 'Dokumen':
                $request->validate([
                    'file' => 'mimes:docx,pdf'
                ]);
                break;
            default:
                break;
        }
        $uploaded = AppHelper::uploader($this->form(),$request);
        $data['atraksi_id'] = $atraksi_id;
        $data['file'] = $uploaded['file'];
        $data['tipe'] = $request->tipe;
        AtraksiFile::create($data);
        Alert::make('success','Berhasil simpan data');
        return redirect(route($this->template['route'].'.index',[$desa_wisata_id,$atraksi_id]));
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
    public function destroy($te,$sid,$id)
    {
        AtraksiFile::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
