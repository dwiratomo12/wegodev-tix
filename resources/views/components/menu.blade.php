<nav class="nav flex-column">
  @foreach($list AS $row)
    <a href="{{ route($row['route']) }}" class="nav-link {{ $isActive($row['label']) ? 'active':'' }}">
      <i class="icon-menu {{ $row['icon'] }}"></i> 
      {{ $row['label'] }}
    </a>
  @endforeach
</nav>