<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <title>@yield('title', 'Furfect')</title>
    @include('layouts.main.styles')
    @yield('styles')

</head>

<body class="@yield('bg', 'bg-gradient-primary')">
    <!-- Main content -->
    <main class="main-content">

        @yield('content')

    </main>

    @include('layouts.main.scripts')

    @yield('script')
</body>

</html>
