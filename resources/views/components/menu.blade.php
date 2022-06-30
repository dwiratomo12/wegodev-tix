<nav class="nav flex-column">
  @if(auth()->user()->role == 'admin')
    @foreach($list AS $row)
      <a href="{{ route($row['route']) }}" class="nav-link {{ $isActive($row['label']) ? 'active':'' }}">
        <i class="icon-menu {{ $row['icon'] }}"></i> 
        {{ $row['label'] }}
      </a>
    @endforeach
  @else
    @foreach($mahasiswa AS $row)
    <a href="{{ route($row['route']) }}" class="nav-link {{ $isActive($row['label']) ? 'active':'' }}">
      <i class="icon-menu {{ $row['icon'] }}"></i> 
      {{ $row['label'] }}
    </a>
    @endforeach
  @endif
</nav>