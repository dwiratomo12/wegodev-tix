<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Room $rooms)
    {
        $q = $request->input('q');

        $active = 'Ruangan';

        $rooms = $rooms->when($q, function ($query) use ($q) {
            return $query->where('nama_ruangan', 'like', '%' . $q . '%');
        })
            ->paginate(10);

        $request = $request->all();
        return view('dashboard/room/list', [
            'rooms'  => $rooms,
            'request'   => $request,
            'active'    => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'Ruangan';

        return view('dashboard/room/form', [
            'active'    => $active,
            'url'       => 'dashboard.rooms.store',
            'button'    => 'Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Room $room)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruangan'              => 'required|unique:App\Models\Room,nama_ruangan',
            'jmlh_komp'                 => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.rooms.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $room->nama_ruangan = $request->input('nama_ruangan');
            $room->jmlh_komp = $request->input('jmlh_komp');
            $room->save();
            return redirect()
                ->route('dashboard.rooms')
                ->with('message', __('messages.store', ['title' => $request->input('nama_ruangan')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $active = 'Ruangan';

        return view('dashboard/room/form', [
            'room'      => $room,
            'active'    => $active,
            'url'       => 'dashboard.rooms.update',
            'button'    => 'Update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $validator = Validator::make($request->all(), [
            'nama_ruangan'      => 'required|unique:App\Models\Room,nama_ruangan,' . $room->id,
            'jmlh_komp'         => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.rooms.update', $room->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $room->nama_ruangan = $request->input('nama_ruangan');
            $room->jmlh_komp = $request->input('jmlh_komp');
            $room->save();
            return redirect()
                ->route('dashboard.rooms')
                ->with('message', __('messages.update', ['title' => $room->nama_ruangan]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $nama_ruangan = $room->nama_ruangan;

        $room->delete();

        return redirect()
            ->route('dashboard.rooms')
            ->with('message', __('messages.delete', ['title' => $nama_ruangan]));
    }
}