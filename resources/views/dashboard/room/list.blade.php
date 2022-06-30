@extends('layouts.dashboard')


@section('content')
  <div class="mb-2">
    <a href="{{ route('dashboard.rooms.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Ruangan</a>
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
          <h3>Ruangan</h3>
        </div>
        {{-- search form --}}
        <div class="col-4">
          <form action="{{ route('dashboard.rooms')}}" method="GET">
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
      @if($rooms->total())
        <table class="table table-borderless table-striped table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Ruangan</th>
              <th>Jumlah Komputer</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
        <tbody>
            @foreach ($rooms as $room)
                <tr> 
                  <td scope="row">{{ ($rooms->currentPage() - 1) * $rooms->perPage() + $loop->iteration }}</td scope="row">
                  <td>
                    {{ $room->nama_ruangan }}
                  </td>
                  <td>
                    {{ $room->jmlh_komp }}
                  </td>
                  <td>
                    <a href="{{ route('dashboard.rooms.edit', $room->id) }}" title="edit" class="btn btn-success btn-sm">
                      <i class="fas fa-pen"></i></a>                      
                  </td>
                </tr>
            @endforeach
        </tbody>
        </table> 

        {{ $rooms->appends($request)->links() }}
      @else
          <h4 class="text-center p-3">{{ __('messages.no_data', ['module' => 'Ruangan']) }}</h4>
      @endif
    </div>
  </div>
   
@endsection