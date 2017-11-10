<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">LiveCalendar</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        @if ($currentUser)
          <li class="navbar-text">You are: <strong>{{ $currentUser->fullName() }} ({{ $currentUser->email }})</strong>
          <li><a href="/logout">Logout</a></li>
        @else
          <li><a href="/login">Login {{ $currentUser }}</a></li>
          <li><a href="/register">Register</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>