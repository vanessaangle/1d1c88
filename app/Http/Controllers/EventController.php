<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Carbon\Carbon;
use App\Helpers\Alert;
use App\Helpers\AppHelper;

class EventController extends Controller
{
    private $template = [
        'title' => 'Event',
        'route' => 'admin.event',
        'menu' => 'event',
        'icon' => 'fa fa-calendar',
        'theme' => 'skin-red'
    ];

    private function form()
    {
        return [
            ['label' => 'Tanggal Berlaku', 'name' => 'tanggal_berlaku','type' => 'datepicker','view_index' => true],
            ['label' => 'File', 'name' => 'file', 'type' => 'file','required' => ['create'],'view_index' => true],
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
        $data = Event::all();
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
            'tanggal_berlaku' => 'required',
            'file' => 'required|mimes:png,jpg,jpeg'
            
        ]);
        $data = $request->all();
        $uploader = AppHelper::uploader($this->form(),$request);
        $data['file'] =  $uploader['file'];
        Event::create($data);
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
        $data = Event::findOrFail($id);
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
        $data = Event::findOrFail($id);
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
            'tanggal_berlaku' => 'required',
        ]);
        $event = Event::find($id);
        $data = $request->all();
        $data['file'] = $event->file;
        if($request->hasFile('file')){
            $uploader = AppHelper::uploader($this->form(),$request);
            $data['file'] = $uploader['file'];
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
        Event::destroy($id);
        Alert::make('success','Berhasil menghapus data');
        return back();
    }
}
