<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Helpers\Alert;

class UserController extends Controller
{
    private $template = [
        'title' => 'Manajemen User',
        'route' => 'admin.user',
        'menu' => 'user',
        'icon' => 'fa fa-users',
        'theme' => 'skin-red',
        'config' => [
            'index.delete.is_show' => false,
        ]
    ];

    private function form()
    {
        $status = [
            ['value' => 'Aktif','name' => 'Aktif'],
            ['value' => 'Tidak Aktif','name' => 'Tidak Aktif']
        ];

        $role = [
            ['value' => 'Admin','name' => 'Admin'],
        ];

        return [
            ['label' => 'Nama Pengguna', 'name' => 'nama','view_index' => true],
            ['label' => 'Alamat', 'name' => 'alamat','view_index' => true],
            ['label' => 'Tanggal Lahir','name' => 'tgl_lahir', 'type' => 'datepicker','view_index' => true],
            ['label' => 'Tempat Lahir','name' => 'tempat_lahir','view_index' => true],
            ['label' => 'Username','name' => 'username','view_index' => true],
            ['label' => 'Password','name' => 'password','type' => 'password'],
            ['label' => 'Status','name' => 'status', 'type' => 'select','option' => $status,'view_index' => true],
            ['label' => 'Role','name' => 'role','type' => 'select','option' => $role,'view_index' => true],
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
        $data = User::all();
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
            'username' => 'required|unique:user',
            'password' => 'required|confirmed|min:6',
            'nama' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'tempat_lahir' => 'required',
            'role' => 'required',
            'status' => 'required'
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['tgl_lahir'] = Carbon::parse($request->tanggal_lahir)->format('Y-m-d');
        User::create($data);
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
        $data = User::findOrFail($id);
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
        $data = User::findOrFail($id);
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
            'username' => "required|unique:user,username,$id",
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data = $request->all();
        if($request ->password == ''){
             unset($data['password']);
        }else{
            $data['password'] = bcrypt($request->password);
        }
        User::find($id)->update($data);
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
        //
    }
}
