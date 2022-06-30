@extends('layouts.dashboard')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8 align-self-center">
          <h3><strong>Jadwal Ruangan</strong></h3>
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
        @foreach ($transactions as $transaction)
          @if($transaction->status == 'accept') 
            <table class="table table-borderless table-striped table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Peminjam</th>
                  <th>NIM/NIP</th>
                  <th>Nama Ruangan</th>
                  <th>Tanggal Pinjam</th>
                  <th>Jam Mulai</th>
                  <th>Jam Selesai</th>
                  <th>Unit Kerja</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                      <th scope="row">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</th scope="row">
                      <td>{{ $transaction->nama_depan }} {{ $transaction->nama_belakang }}</td>
                      <td>{{ $transaction->nim }}</td>
                      <td>{{ $transaction->nama_ruangan }}</td>
                      <td>{{ $transaction->tanggal_pinjam }}</td>
                      <td>{{ $transaction->jam_mulai }}</td>
                      <td>{{ $transaction->jam_selesai }}</td>
                      <td>{{ $transaction->unit_kerja }}</td>                    
                    </tr>
                @endforeach
              </tbody>
            </table> 
            {{ $transactions->appends($request)->links() }}
          @endif
        @endforeach
      @else
          <h4 class="text-center p-3">{{ __('messages.no_data', ['module' => 'Transaksi']) }}</h4>
      @endif
    </div>
  </div>
   
</div>
@endsection