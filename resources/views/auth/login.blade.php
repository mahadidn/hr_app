@extends('layouts.auth')

@section('title', 'Secure Login — HRApp Enterprise')

@section('content')
<div class="login-page">
    <div class="split-panel">

        {{-- ===================== LEFT PANEL ===================== --}}
        <div class="panel-left">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>

            <div class="left-brand">
                <div class="left-brand-logo">
                    <i class="fa-solid fa-hexagon-nodes"></i>
                </div>
                <div>
                    <div class="left-brand-name">HR App</div>
                    <div class="left-brand-tag">Enterprise</div>
                </div>
            </div>

            <div class="left-illustration">
                
                <div class="left-headline">
                    HR Management<br>
                </div>
                <p class="left-subtext">
                    An integrated enterprise HR platform for department management, employee management, and attendance tracking.
                </p>
            </div>

            <div class="left-stats">
                
            </div>
        </div>

        {{-- ===================== RIGHT PANEL ===================== --}}
        <div class="panel-right">

            {{-- Theme Toggle Button --}}
            <button class="btn-theme-toggle" id="themeToggle" title="Ganti Tema" aria-label="Toggle dark/light mode">
                <i class="fa-solid fa-sun" id="themeIcon"></i>
            </button>

            <div class="form-header">
                <div class="form-eyebrow">
                    <i class="fa-solid fa-lock-keyhole me-1"></i> Secure Access
                </div>
                <h1 class="form-heading">Welcome Back</h1>
                <p class="form-subheading">Sign in to your HR Administrator account.</p>
            </div>

            {{-- Error alert (validasi Laravel / wrong credentials) --}}
            @if ($errors->any() || session('error'))
                <div class="alert-enterprise alert-error" role="alert">
                    <div class="alert-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <div class="alert-content">
                        <div class="alert-title">Login Failed</div>
                        @if (session('error'))
                            <div>{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Success / status alert --}}
            @if (session('status') || session('success'))
                <div class="alert-enterprise alert-success" role="alert">
                    <div class="alert-icon"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="alert-content">
                        <div class="alert-title">Information</div>
                        <div>{{ session('status') ?? session('success') }}</div>
                    </div>
                </div>
            @endif

            {{-- =================== FORM =================== --}}
            <form method="POST" action="{{ route('login.submit') }}" id="loginForm" novalidate>
                @csrf

                {{-- Email --}}
                <div class="field-group">
                    <label for="email" class="field-label">Email Address</label>
                    <div class="input-wrap">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="field-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="john@gmail.com"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            autofocus
                            required
                        >
                        <i class="fa-solid fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="field-error-msg">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field-group">
                    <label for="password" class="field-label">Password</label>
                    <div class="input-wrap">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="field-input has-eye {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="Input your password"
                            autocomplete="current-password"
                            required
                        >
                        <i class="fa-solid fa-lock input-icon"></i>
                        <button type="button" class="btn-eye" id="togglePassword" title="Tampilkan/Sembunyikan Password">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error-msg">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember Me + Forgot --}}
                <div class="row-remember">
                    <label class="custom-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="btnLogin">
                    <span class="btn-label">
                        <i class="fa-solid fa-right-to-bracket me-1"></i>
                        Log In
                    </span>
                    <span class="btn-spinner">
                        <i class="fa-solid fa-spinner fa-spin"></i>
                        Verifying&hellip;
                    </span>
                </button>

            </form>

            <div class="form-footer">
                <strong>HR App Enterprise</strong><br>
                &copy; {{ date('Y') }} PT. HR App Indonesia. All rights reserved.
            </div>

        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function () {

            /* =====================================================
            THEME MANAGER — Dark / Light Mode
            Prioritas: localStorage → preferensi OS → default light
            ===================================================== */
            var THEME_KEY = 'hrapp_theme';
            var $html     = $('html');

            function getOsTheme() {
                return (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
                    ? 'dark' : 'light';
            }

            function applyTheme(theme) {
                $html.attr('data-theme', theme);
                if (theme === 'dark') {
                    $('#themeIcon').removeClass('fa-sun').addClass('fa-moon');
                    $('#themeToggle').attr('title', 'Ganti ke Mode Terang');
                } else {
                    $('#themeIcon').removeClass('fa-moon').addClass('fa-sun');
                    $('#themeToggle').attr('title', 'Ganti ke Mode Gelap');
                }
            }

            // Baca preferensi: localStorage dulu, fallback ke OS
            var savedTheme = localStorage.getItem(THEME_KEY) || getOsTheme();
            applyTheme(savedTheme);

            // Klik toggle → ganti & simpan
            $('#themeToggle').on('click', function () {
                var current = $html.attr('data-theme');
                var next    = current === 'dark' ? 'light' : 'dark';
                applyTheme(next);
                localStorage.setItem(THEME_KEY, next);
            });

            // Ikuti perubahan OS secara real-time (jika belum ada preferensi manual)
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
                    if (!localStorage.getItem(THEME_KEY)) {
                        applyTheme(e.matches ? 'dark' : 'light');
                    }
                });
            }

            /* =====================================================
            PASSWORD VISIBILITY TOGGLE
            ===================================================== */
            $('#togglePassword').on('click', function () {
                var $input  = $('#password');
                var $icon   = $('#eyeIcon');
                var isHidden = $input.attr('type') === 'password';
                $input.attr('type', isHidden ? 'text' : 'password');
                $icon.toggleClass('fa-eye', !isHidden).toggleClass('fa-eye-slash', isHidden);
            });

            /* =====================================================
            FORM SUBMIT — client-side validation + loading state
            ===================================================== */
            $('#loginForm').on('submit', function (e) {
                var email    = $.trim($('#email').val());
                var password = $.trim($('#password').val());
                var valid    = true;

                // Clear previous inline errors
                $('.field-input').removeClass('is-invalid');
                $('.js-field-error').remove();

                if (!email) {
                    showFieldError('#email', 'Email must not be empty.');
                    valid = false;
                } else if (!isValidEmail(email)) {
                    showFieldError('#email', 'Email Format is not valid.');
                    valid = false;
                }

                if (!password) {
                    showFieldError('#password', 'Password must not be empty.');
                    valid = false;
                } else if (password.length < 6) {
                    showFieldError('#password', 'Password must be at least 6 characters long.');
                    valid = false;
                }

                if (!valid) { e.preventDefault(); return; }

                // Aktifkan loading state
                $('#btnLogin').addClass('loading').prop('disabled', true);
            });

            function showFieldError(selector, message) {
                var $input = $(selector);
                $input.addClass('is-invalid');
                $input.closest('.input-wrap').after(
                    '<div class="field-error-msg js-field-error">' +
                    '<i class="fa-solid fa-triangle-exclamation"></i> ' + message +
                    '</div>'
                );
            }

            function isValidEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            /* =====================================================
            Auto-clear loading state bila back button ditekan
            ===================================================== */
            $(window).on('pageshow', function (e) {
                if (e.originalEvent.persisted) {
                    $('#btnLogin').removeClass('loading').prop('disabled', false);
                }
            });

            /* =====================================================
            SweetAlert2 — flash dari server
            Controller: return back()->with('swal_error', 'Pesan');
            ===================================================== */
            @if(session('swal_error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: "{{ addslashes(session('swal_error')) }}",
                    confirmButtonColor: '#4f6ef7',
                    confirmButtonText: 'Coba Lagi'
                });
            @endif

            @if(session('swal_success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ addslashes(session('swal_success')) }}",
                    confirmButtonColor: '#4f6ef7',
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            @endif

        });
    </script>
@endsection