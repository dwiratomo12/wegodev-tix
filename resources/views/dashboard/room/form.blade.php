@extends('layouts.dashboard')


@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8 align-self-center">
          <h3>Rooms</h3>
        </div>
        {{-- search form --}}
        <div class="col-4 text-right">
          <button class="btn btn-sm text-secondary" title="Delete" data-toggle="modal" data-target="#deleteModal">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
    </div>
        
    <div class="card-body">
      <div class="row">
        <div class="col-md-8 offset-md-2">
        <form action="{{ route($url, $room->id ?? '') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($room))
            @method('put')
          @endif
          <div class="form-group">
            <label for="nama_ruangan">Nama Ruangan</label>
            <input type="text" class="form-control @error('nama_ruangan') {{ 'is-invalid' }} @enderror" name="nama_ruangan" value="{{ old('nama_ruangan') ?? $room->nama_ruangan ?? ''}}">
            @error('nama_ruangan')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="jmlh_komp">Jumlah Komputer</label>
            <input type="text" class="form-control @error('jmlh_komp') {{ 'is-invalid' }} @enderror" name="jmlh_komp" value="{{ old('jmlh_komp') ?? $room->jmlh_komp ?? ''}}">
            @error('jmlh_komp')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>          
          <div class="form-group mb-0">
            <button type="button" onclick="window.history.back()" class="btn btn-sm btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-success btn-sm">{{ $button }}</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  @if(isset($room))
  <div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Delete</h5>
          <button type="button" class="close" title="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p>Anda yaking ingin hapus ruangan {{ $room->nama_ruangan }}</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <form action="{{ route('dashboard.rooms.delete', $room->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"> Delete</i></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endif
   
@endsection