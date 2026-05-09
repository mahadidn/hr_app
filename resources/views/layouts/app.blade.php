<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HR Dashboard') — HR App</title>

    {{-- Calling CSS --}}
    @include('layouts.partials.styles')

    {{-- Page-specific CSS --}}
    @yield('css')

    <script>
        (function() {
            var saved = localStorage.getItem('hrapp_theme');
            var osTheme = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', saved || osTheme);
        })();
    </script>
</head>
<body>

    <div class="layout-wrapper">

        {{-- display the sidebar --}}
        @include('layouts.partials.sidebar')

        <div class="main-wrapper" id="mainWrapper">

            {{-- display the navbarr --}}
            @include('layouts.partials.navbar')

            {{-- Main Content Area --}}
            <main class="page-content">
                @yield('content')
            </main>

            {{-- display the footer --}}
            @include('layouts.partials.footer')

        </div>

    </div>

    {{-- Calling JavaScript --}}
    @include('layouts.partials.scripts')

    {{-- Page-specific scripts --}}
    @yield('scripts')

</body>
</html>