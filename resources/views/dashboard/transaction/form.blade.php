@extends('layouts.dashboard')


@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8 align-self-center">
          <h3>Data Peminjaman</h3>
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
        <form action="{{ route($url, $transaction->id ?? '') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($transaction))
            {{-- @method('put') --}}
          @endif
          <div class="form-group">
            <label for="ruangan">Ruangan</label>
            <select name="room_id" class="form-control">
              <option value="">Pilih Ruangan</option>
              @foreach($rooms as $room)
                @if($room->id == (old('room_id') ?? ''))
                  <option value="{{ $room->id }}" selected>{{ $room->nama_ruangan }}</option>
                @else
                  <option value="{{ $room->id }}">{{ $room->nama_ruangan }}</option>
                @endif
                {{-- <input type="hidden" class="form-control" name="nama_ruangan" value="{{ $room->nama_ruangan }}"> --}}
              @endforeach
            </select>
            @error('room_id')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="nim">NIM/NIP</label>
            <input type="text" class="form-control @error('nim') {{ 'is-invalid' }} @enderror" name="nim" value="{{ old('nim') ?? $user->nip ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="nama_depan">Nama Depan</label>
            <input type="text" class="form-control @error('nama_depan') {{ 'is-invalid' }} @enderror" name="nama_depan" value="{{ old('nama_depan') ?? $user->name ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="nama_belakang">Nama Belakang</label>
            <input type="text" class="form-control @error('nama_belakang') {{ 'is-invalid' }} @enderror" name="nama_belakang" value="{{ old('nama_belakang') ?? $transaction->nama_belakang ?? ''}}">
          </div>
          <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" class="form-control @error('tanggal_pinjam') {{ 'is-invalid' }} @enderror" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') ?? $transaction->tanggal_pinjam ?? ''}}">
          </div>
          <div class="form-group">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" class="form-control @error('jam_mulai') {{ 'is-invalid' }} @enderror" name="jam_mulai" value="{{ old('jam_mulai') ?? $transaction->jam_mulai ?? ''}}">
          </div>
          <div class="form-group">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" class="form-control @error('jam_selesai') {{ 'is-invalid' }} @enderror" name="jam_selesai" value="{{ old('jam_selesai') ?? $transaction->jam_selesai ?? ''}}">
          </div>
          <div class="form-group">
            <label for="unit_kerja">Unit Kerja</label>
            <input type="text" class="form-control @error('unit_kerja') {{ 'is-invalid' }} @enderror" name="unit_kerja" value="{{ old('unit_kerja') ?? $transaction->unit_kerja ?? ''}}" placeholder="Unit Kerja/ORMAWA">
          </div>
          <div class="form-group">
            <label for="keterangan">keterangan</label>
            <textarea name="keterangan" class="form-control @error('keterangan') {{ 'is-invalid' }} @enderror" cols="30" rows="10" placeholder="Tujuan dari peminjaman ruangan">{{ old('keterangan') ?? $transaction->keterangan ?? ''}}</textarea>
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

  @if(isset($transaction))
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
          <p>Anda yaking ingin hapus transaksi</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <form action="{{ route('dashboard.transaction.delete', $transaction->id) }}" method="POST">
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