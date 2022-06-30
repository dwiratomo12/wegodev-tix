<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Room;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Transaction $transactions)
    {
        $q = $request->input('q');

        $active = 'Transaction';
        $user = Auth::user();

        $transactions = $transactions->when($q, function ($query) use ($q) {
            return $query->where('nama_ruangan', 'like', '%' . $q . '%')
                ->orwhere('nama_depan', 'like', '%' . $q . '%')
                ->orwhere('nama_belakang', 'like', '%' . $q . '%')
                ->orwhere('nama_ruangan', 'like', '%' . $q . '%')
                ->orwhere('nim', 'like', '%' . $q . '%');
        })
            ->paginate(10);
        if (auth()->user()->role == 'admin') {
            $request = $request->all();
            return view('dashboard/transaksi/listadmin', [
                'transactions'      => $transactions,
                'request'           => $request,
                'active'            => $active
            ]);
        } else {
            $request = $request->all();
            return view('dashboard/transaksi/listuser', [
                'transactions'      => $transactions,
                'user'              => $user,
                'request'           => $request,
                'active'            => $active
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'Transaction';
        $user = Auth::user();
        $rooms = Room::get();

        return view('dashboard/transaction/form', [
            'active'        => $active,
            'user'          => $user,
            'rooms'         => $rooms,
            'url'           => 'dashboard.transactions.store',
            'button'        => 'Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaction $transaction, User $user)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_pinjam'    => 'required',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'unit_kerja'        => 'required',
            'keterangan'        => 'required',
        ]);
        $user = Auth::user();
        $room = Room::find($request->input('room_id'));

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.transactions.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $transaction->room_id = $request->input('room_id');
            $transaction->nama_ruangan = $room->nama_ruangan;
            $transaction->nim = $user->nip;
            $transaction->nama_depan = $user->name;
            $transaction->nama_belakang = $request->input('nama_belakang');
            $transaction->tanggal_pinjam = $request->input('tanggal_pinjam');
            $transaction->jam_mulai = $request->input('jam_mulai');
            $transaction->jam_selesai = $request->input('jam_selesai');
            $transaction->unit_kerja = $request->input('unit_kerja');
            $transaction->keterangan = $request->input('keterangan');
            $transaction->status = 'proses';
            $transaction->save();
            return redirect()
                ->route('dashboard.transactions')
                ->with('message', __('messages.store', ['title' => $request->input('nama_ruangan')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $active = 'Transaction';

        return view('dashboard/transaksi/formadmin', [
            'transaction'   => $transaction,
            'active'        => $active,
            'url'           => 'dashboard.transactions.update',
            'button'        => 'Update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'status'    => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.transactions.update', $transaction->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $transaction->status = $request->input('status');
            $transaction->save();
            return redirect()
                ->route('dashboard.transactions')
                ->with('message', __('messages.update', ['title' => $transaction->nim]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $nama_peminjam = $transaction->nama_depan . ' ' . $transaction->nama_belakang;

        $transaction->delete();

        return redirect()
            ->route('dashboard.transactions')
            ->with('message', __('messages.delete', ['title' => $nama_peminjam]));
    }
}