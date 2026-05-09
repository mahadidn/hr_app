<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign In — HR App Enterprise')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- Masukkan semua tag <style> dari kode awal ke sini --}}
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <script>
        (function() {
            var saved = localStorage.getItem('hrapp_theme');
            var osTheme = (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', saved || osTheme);
        })();
    </script>
</head>
<body>

    {{-- Area Konten Dinamis --}}
    @yield('content')

    {{-- Scripts Dasar --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    {{-- Area untuk Script Spesifik Halaman --}}
    @yield('scripts')

</body>
</html>