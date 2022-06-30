@extends('layouts.dashboard')


@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8 align-self-center">
          <h3>Mahasiswa</h3>
        </div>
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
        <form action="{{ route($url, $mahasiswa->id ?? '') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @if(isset($mahasiswa))
            @method('put')
          @endif
          <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control @error('nim') {{ 'is-invalid' }} @enderror" name="nim" value="{{ old('nim') ?? $mahasiswa->nim ?? ''}}">
            @error('nim')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="nama_depan">Nama depan</label>
            <input type="text" class="form-control @error('nama_depan') {{ 'is-invalid' }} @enderror" name="nama_depan" value="{{ old('nama_depan') ?? $mahasiswa->nama_depan ?? ''}}">
            @error('nama_depan')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="nama_belakang">Nama belakang</label>
            <input type="text" class="form-control @error('nama_belakang') {{ 'is-invalid' }} @enderror" name="nama_belakang" value="{{ old('nama_belakang') ?? $mahasiswa->nama_belakang ?? ''}}">
            @error('nama_belakang')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control @error('email') {{ 'is-invalid' }} @enderror" name="email" value="{{ old('email') ?? $mahasiswa->email ?? ''}}">
            @error('email')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="jenis_kelamin">Jenis kelamin</label>
            <select name="jenis_kelamin" class="form-control">
              <option value="">Pilih Jenis Kelamin</option>          
              <option value="Laki-laki" @if(isset($mahasiswa))@if($mahasiswa->jenis_kelamin == 'Laki-laki') selected @endif @endif>Laki-laki</option>
              <option value="Perempuan" @if(isset($mahasiswa))@if($mahasiswa->jenis_kelamin == 'Perempuan') selected @endif @endif>Perempuan</option>
            </select>
            @error('jenis_kelamin')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="agama">Agama</label>
            <input type="text" class="form-control @error('agama') {{ 'is-invalid' }} @enderror" name="agama" value="{{ old('agama') ?? $mahasiswa->agama ?? ''}}">
            @error('agama')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="alamat">alamat</label>
            <textarea name="alamat" class="form-control @error('alamat') {{ 'is-invalid' }} @enderror" cols="30" rows="10">{{ old('alamat') ?? $mahasiswa->alamat ?? ''}}</textarea>
            @error('alamat')
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

  @if(isset($mahasiswa))
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
          <p>Anda yaking ingin hapus {{$mahasiswa->nama_depan}}</p>
        </div>

        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          <form action="{{ route('dashboard.mahasiswa.delete', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"> Delete</i></button>
          </form>
        </div> --}}
      </div>
    </div>
  </div>
  @endif
   
@endsection