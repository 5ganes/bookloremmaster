<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item">
      <form method="POST" action="{{ config('app.url') }}booksearch">
        @csrf
        <input type="text" class="form-control" name="keyword" placeholder="Search Books" required>
      </form>
    </li>
    <li class="nav-item active">
      <a class="nav-link" href="#" style="background-color: #042144;">
        <i class="fas fa-align-justify"></i>
        <span style="font-size: 20px;">Book Categories</span>
      </a>
    </li>
    
    @php $count = 1; @endphp
    @foreach($categoryList as $category)
      <li class="nav-item">
        <a class="nav-link" href="{{ config('app.url') }}bookcategory/{{$category->id}}">
          <span>{{$category->name}}</span>
        </a>
      </li>
    @endforeach

</ul>