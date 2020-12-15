<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="{{ config('app.adminurl') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>

    @if(Auth::user()->type == 'admin')
      <li class="nav-item">
        <a class="nav-link" href="{{ config('app.adminurl') }}userlist">
          <i class="fa fa-user"></i>
          <span>User Management</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ config('app.adminurl') }}categorylist">
          <i class="fa fa-list"></i>
          <span>Book Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ config('app.adminurl') }}publisherlist">
          <i class="fa fa-list"></i>
          <span>Book Publishers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ config('app.adminurl') }}authorlist">
          <i class="fa fa-pen"></i>
          <span>Author Management</span>
        </a>
      </li>
    @endif
    
    <li class="nav-item">
      <a class="nav-link" href="{{ config('app.adminurl') }}booklist">
        <i class="fa fa-book"></i>
        <span>Book Management</span>
      </a>
    </li>
</ul>