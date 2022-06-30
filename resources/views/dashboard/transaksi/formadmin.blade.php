@extends('layouts.dashboard')


@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8 align-self-center">
          <h3>Transaction</h3>
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
            @method('put')
          @endif
          <div class="form-group">
            <label for="nama_ruangan">Ruangan</label>
            <input type="text" class="form-control @error('nama_ruangan') {{ 'is-invalid' }} @enderror" name="nama_ruangan" value="{{ old('nama_ruangan') ?? $transaction->nama_ruangan ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="nim">NIM/NIP</label>
            <input type="text" class="form-control @error('nim') {{ 'is-invalid' }} @enderror" name="nim" value="{{ old('nim') ?? $transaction->nim ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="nama_depan">Nama Depan</label>
            <input type="text" class="form-control @error('nama_depan') {{ 'is-invalid' }} @enderror" name="nama_depan" value="{{ old('nama_depan') ?? $transaction->nama_depan ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="nama_belakang">Nama Belakang</label>
            <input type="text" class="form-control @error('nama_belakang') {{ 'is-invalid' }} @enderror" name="nama_belakang" value="{{ old('nama_belakang') ?? $transaction->nama_belakang ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="tanggal_pinjam">Tanggal Pinjam</label>
            <input type="date" class="form-control @error('tanggal_pinjam') {{ 'is-invalid' }} @enderror" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') ?? $transaction->tanggal_pinjam ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" class="form-control @error('jam_mulai') {{ 'is-invalid' }} @enderror" name="jam_mulai" value="{{ old('jam_mulai') ?? $transaction->jam_mulai ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" class="form-control @error('jam_selesai') {{ 'is-invalid' }} @enderror" name="jam_selesai" value="{{ old('jam_selesai') ?? $transaction->jam_selesai ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="unit_kerja">Unit Kerja</label>
            <input type="text" class="form-control @error('unit_kerja') {{ 'is-invalid' }} @enderror" name="unit_kerja" value="{{ old('unit_kerja') ?? $transaction->unit_kerja ?? ''}}" readonly>
          </div>
          <div class="form-group">
            <label for="keterangan">keterangan</label>
            <textarea name="keterangan" class="form-control @error('keterangan') {{ 'is-invalid' }} @enderror" cols="30" rows="10" readonly>{{ old('keterangan') ?? $transaction->keterangan ?? ''}}</textarea>
          </div>
          <div class="mb-2">
            <div class="form-group mb-0">
              <label for="status">Status</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" name="status" class="form-check-input" value="proses" id="proses" @if((old('status') ?? $transaction->status ?? '') == 'proses') checked @endif>
              <label for="proses" class="form-check-label">proses</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" name="status" class="form-check-input" value="accept" id="accept" @if((old('status') ?? $transaction->status ?? '') == 'accept') checked @endif>
              <label for="accept" class="form-check-label">Accept</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" name="status" class="form-check-input" value="decline" id="decline" @if((old('status') ?? $transaction->status ?? '') == 'decline') checked @endif>
              <label for="decline" class="form-check-label">Decline</label>
            </div>
            @error('status')
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

  @if(isset($movie))
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
          <p>Anda yaking ingin hapus movie</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <form action="{{ route('dashboard.movies.delete', $movie->id) }}" method="POST">
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