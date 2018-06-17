<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
    <body>
    <div class="container">
        <header class="row">
            @include('includes.navbar')
        </header>
        <div id="main" class="row">
            <!-- main content -->
            <div id="content" class="col-md-8">
                @yield('content')
            </div>
            <!-- sidebar content -->
            <div id="sidebar" class="col-md-4">
                @include('includes.sidebar')
            </div>
        </div>
        <footer class="row">
            @include('includes.footer')
        </footer>
    </div>
</body>
</html>