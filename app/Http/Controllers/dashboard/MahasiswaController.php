<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Finder\Finder;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Mahasiswa $mahasiswa)
    {
        $q = $request->input('q');

        $active = 'Users';

        $mahasiswa = $mahasiswa->when($q, function ($query) use ($q) {
            return $query->where('nama_depan', 'like', '%' . $q . '%')
                ->orwhere('nama_belakang', 'like', '%' . $q . '%')
                ->orwhere('nim', 'like', '%' . $q . '%');
        })
            ->paginate(10);

        $request = $request->all();
        return view('dashboard/mahasiswa/list', [
            'mahasiswa' => $mahasiswa,
            'request' => $request,
            'active' => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'Users';


        return view('dashboard/mahasiswa/form', [
            'active'    => $active,
            'button'    => 'Create',
            'url'       => 'dashboard.mahasiswa.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'nim'               => 'required|unique:mahasiswa',
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'email'             => 'required',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'alamat'            => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.mahasiswa.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            //insert ke table user 
            $user = new User;
            $user->nip = $request->input('nim');
            $user->role = 'siswa';
            $user->name = $request->input('nama_depan');
            $user->email = $request->input('email');
            $user->password = bcrypt($user->nip);
            $user->remember_token = Str::random(60);
            $user->save();

            //insert ke table mahasiswa
            $mahasiswa->user_id =  $user->id;
            $mahasiswa->nim = $request->input('nim');
            $mahasiswa->nama_depan = $request->input('nama_depan');
            $mahasiswa->nama_belakang = $request->input('nama_belakang');
            $mahasiswa->email = $request->input('email');
            $mahasiswa->jenis_kelamin = $request->input('jenis_kelamin');
            $mahasiswa->agama = $request->input('agama');
            $mahasiswa->alamat = $request->input('alamat');
            $mahasiswa->save();


            return redirect()
                ->route('dashboard.mahasiswa')
                ->with('message', __('messages.store', ['title' => $request->input('nama_depan')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa, $id)
    {
        $active = 'Users';
        $mahasiswa = Mahasiswa::find($id);
        return view('dashboard/mahasiswa/form', [
            'mahasiswa' => $mahasiswa,
            'active'    => $active,
            'url'       => 'dashboard.mahasiswa.update',
            'button'    => 'Update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa, $id)
    {
        $validator = Validator::make($request->all(), [
            'nim'               => 'required',
            'nama_depan'        => 'required',
            'nama_belakang'     => 'required',
            'email'             => 'required',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'alamat'            => 'required',
        ]);
        $mahasiswa = Mahasiswa::find($id);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.mahasiswa.update', $mahasiswa->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            //insert ke table mahasiswa
            $mahasiswa->nim = $request->input('nim');
            $mahasiswa->nama_depan = $request->input('nama_depan');
            $mahasiswa->nama_belakang = $request->input('nama_belakang');
            $mahasiswa->email = $request->input('email');
            $mahasiswa->jenis_kelamin = $request->input('jenis_kelamin');
            $mahasiswa->agama = $request->input('agama');
            $mahasiswa->alamat = $request->input('alamat');
            $mahasiswa->save();
            return redirect()
                ->route('dashboard.mahasiswa')
                ->with('message', __('messages.update', ['title' => $request->input('nama_depan')]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa, $id)
    {
        $title = $mahasiswa->nama_depan;
        $mahasiswa = Mahasiswa::find($id);

        $mahasiswa->delete($mahasiswa);

        return redirect()
            ->route('dashboard.mahasiswa')
            ->with('message', __('messages.delete', ['title' => $title]));
    }
}