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
    @include('includes.footer')
</body>
</html>
