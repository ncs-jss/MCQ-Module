<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="bg">
    @include('includes.header')
    <main role="main">
        @yield('content')
    </main>
    <footer class=" footer">
        @include('includes.footer')
    </footer>
</body>
</html>
