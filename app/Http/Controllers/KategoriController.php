<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\Desa;
use Carbon\Carbon;
use App\Helpers\Alert;
use App\Helpers\AppHelper;

class KategoriController extends Controller
{
    private $template = [
        'title' => 'Kategori',
        'route' => 'admin.kategori',
        'menu' => 'kategori',
        'icon' => 'fa fa-tags',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            ['label' => 'Nama Kategori', 'name' => 'nama_kategori','view_index' => true],
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
        $data = Kategori::all();
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
        
        $data = $request->all();
        Kategori::create($data);
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
        $data = Kategori::findOrFail($id);
        $form = $this->form();
        return view('admin.master.show',compact('template','data','form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Kategori::findOrFail($id);
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
        $data = $request->all();
        
        Kategori::find($id)->update($data);
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
        Kategori::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
