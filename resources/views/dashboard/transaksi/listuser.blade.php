@extends('layouts.dashboard')


@section('content')
  <div class="mb-2">
    <a href="{{ url('/dashboard/create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Pinjam Ruangan</a>
  </div>

  @if(session()->has('message'))
    <div class="alert alert-success">
      <strong>{{ session()->get('message') }}</strong>
      <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
    </div>
  @endif

  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8 align-self-center">
          <h3>Data Transaksi</h3>
        </div>
        {{-- search form --}}
        <div class="col-4">
          <form action="{{ route('dashboard.transactions')}}" method="GET">
            <div class="input-group">
              <input type="text" class="form-control form-control-sm" name="q" value="{{ $request['q'] ?? '' }}">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary btn-sm">Search</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
        
    <div class="card-body p-0">
      @if($transactions->total())
        {{-- @if($transactions->nim == $user->nip) --}}
        @foreach ($transactions as $transaction)
          @if($transaction->nim == $user->nip)        
            <table class="table table-borderless table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Peminjam</th>
                  <th>NIM/NIP</th>
                  <th>Tanggal Pinjam</th>
                  <th>Nama Ruangan</th>
                  <th>Jam Mulai</th>
                  <th>Keterangan</th>
                  <th>status</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                      <th scope="row">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</th scope="row">
                      <td>{{ $transaction->nama_depan }} {{ $transaction->nama_belakang }}</td>
                      <td>{{ $transaction->nim }}</td>
                      <td>{{ $transaction->tanggal_pinjam }}</td>
                      <td>{{ $transaction->nama_ruangan }}</td>
                      <td>{{ $transaction->jam_mulai }}</td>
                      <td>{{ $transaction->keterangan }}</td>
                      <td class="mt-1 @if($transaction->status == 'proses' || $transaction->status == 'decline') 
                        badge bg-danger text-white
                        @else
                        badge bg-success text-white
                        @endif">{{ $transaction->status }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table> 
            {{ $transactions->appends($request)->links() }}
            {{-- @endif --}}
          @endif
        @endforeach
      @else
          <h4 class="text-center p-3">{{ __('messages.no_data', ['module' => 'Transaksi']) }}</h4>
      @endif
    </div>
  </div>
   
@endsection