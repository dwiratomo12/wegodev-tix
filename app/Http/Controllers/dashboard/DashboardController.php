<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Transaction $transactions)
    {
        $q = $request->input('q');
        $active = 'Dashboard';

        $transactions = $transactions->when($q, function ($query) use ($q) {
            return $query->where('nama_ruangan', 'like', '%' . $q . '%')
                ->orwhere('nama_depan', 'like', '%' . $q . '%')
                ->orwhere('nama_belakang', 'like', '%' . $q . '%')
                ->orwhere('nama_ruangan', 'like', '%' . $q . '%')
                ->orwhere('nim', 'like', '%' . $q . '%');
        })
            ->paginate(10);

        $request = $request->all();
        return view('home', [
            'transactions'      => $transactions,
            'request'           => $request,
            'active'            => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        //
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