<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark shadow">
    <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'MCQ Module') }}
    </a>
		<!-- Toggler/collapsibe Button -->
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
  	</button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
		<ul class="navbar-nav mr-auto">
    		<li class="nav-item active">
      			<a class="nav-link" href="{{ url('/') }}">Home</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link" href="#">About</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link" href="#">NCS</a>
    		</li>
    		<li class="nav-item">
      			<a class="nav-link disabled" href="#">Disabled</a>
    		</li>
  	</ul>
    </div>
    @if (Auth::check())
      @if (session()->has('event'))
        <button class="btn btn-danger my-2 my-sm-0" type="button" data-toggle="modal" data-target="#EventLogout" data-whatever="@fat">Logout</button>
      @else
        <a href="{{ route('logout') }}"><button class="btn btn-danger my-2 my-sm-0" type="submit">Logout</button></a>
      @endif
    @endif
</nav>
