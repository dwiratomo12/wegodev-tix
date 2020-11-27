@extends('layouts.dashboard')


@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-8">
          <h3>Users</h3>
        </div>
      </div>
    </div>
        
    <div class="card-body p-0">
      <table class="table">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Registered</th>
          <th>Edited</th>
        </tr>
        @foreach ($users as $user)
            <tr>
              <td>1</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at }}</td>
              <td>{{ $user->updated_at }}</td>
            </tr>
        @endforeach
      </table> 

      {{ $users->links() }}
    </div>
  </div>
   
@endsection