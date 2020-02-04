<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use Illuminate\Http\Request;
use App\Helpers\AppHelper;
use App\Helpers\Alert;

class CalendarEventController extends Controller
{
    private $template = [
        'title' => 'Event',
        'route' => 'admin.calendar',
        'menu' => 'calendar',
        'icon' => 'fa fa-calendar',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            [
                'label' => 'Judul',
                'name' => 'judul',
                'view_index' => true
            ],
            [
                'label' => 'Deskripsi',
                'name' => 'deskripsi',
                'type' => 'ckeditor',
            ],
            [
                'label' => 'Foto',
                'name' => 'foto',
                'type' => 'file',
                'required' => ['create']
            ]
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
        $data = CalendarEvent::all();
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
            'judul' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|mimes:png,jpg,jpeg'
        ]);
        $data = $request->all();
        $uploader = AppHelper::uploader($this->form(),$request);
        $data['foto'] =  $uploader['foto'];
        CalendarEvent::create($data);
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
        $data = CalendarEvent::findOrFail($id);
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
        $data = CalendarEvent::findOrFail($id);
        $template = (object)$this->template;
        $form = $this->form();
        return view('admin.desawisata.edit',compact('template','form','data'));
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
            'judul' => 'required',
            'deskripsi' => 'required'
        ]);
        $event = CalendarEvent::find($id);
        $data = $request->all();
        $data['foto'] = $event->foto;
        if($request->hasFile('foto')){
            $uploader = AppHelper::uploader($this->form(),$request);
            $data['foto'] = $uploader['foto'];
        }
        $event->update($data);
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
        CalendarEvent::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
