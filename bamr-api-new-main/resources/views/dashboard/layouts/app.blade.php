<!DOCTYPE html>
<html lang="en">

@yield('head')
@vite('resources/css/api.css')
@yield('styles')

<body>
@include('dashboard.layouts.navigation')
@yield('content')
@yield('scripts')
@vite('resources/js/app.js')

</body>

</html>
