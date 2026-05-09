{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Bootstrap 5 Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    $(function () {

        /* =====================================================
           THEME MANAGER — Dark / Light Mode
        ===================================================== */
        const THEME_KEY    = 'hrapp_theme';
        const $html        = $('html');
        const $themeIcon   = $('#themeIcon');
        const $themeToggle = $('#themeToggle');

        // Ikon per tema
        function getIcon(theme) {
            return theme === 'dark'
                ? '<i class="fa-solid fa-moon"></i>'
                : '<i class="fa-solid fa-sun"></i>';
        }

        // apply theme into DOM
        function applyTheme(theme) {
            $html.attr('data-theme', theme);
            $('#themeThumb').html(getIcon(theme));
            $themeToggle.attr('title', theme === 'dark'
                ? 'Switch to Light Mode'
                : 'Switch to Dark Mode'
            );
        }

        // Read saved preferences; fall back to 'light'
        const savedTheme = localStorage.getItem(THEME_KEY) || 'light';
        applyTheme(savedTheme);

        // Click the toggle → change the theme & save
        $themeToggle.on('click', function () {
            const current = $html.attr('data-theme');
            const next    = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem(THEME_KEY, next);
        });


        /* =====================================================
           SIDEBAR TOGGLE
           Desktop: right-hand content; Mobile: overlay.
        ===================================================== */
        const $sidebar  = $('#mainSidebar');
        const $wrapper  = $('#mainWrapper');
        const $backdrop = $('#sidebarBackdrop');
        const MOBILE_BP = 992; // px

        function isMobile() {
            return $(window).width() < MOBILE_BP;
        }

        $('#btnToggleSidebar').on('click', function () {
            if (isMobile()) {
                // Mobile: display as an overlay
                const isOpen = $sidebar.hasClass('mobile-open');
                if (isOpen) {
                    $sidebar.removeClass('mobile-open');
                    $backdrop.removeClass('show');
                } else {
                    $sidebar.addClass('mobile-open');
                    $backdrop.addClass('show');
                }
            } else {
                // Desktop: collapse → expand content
                const isCollapsed = $sidebar.hasClass('collapsed');
                if (isCollapsed) {
                    $sidebar.removeClass('collapsed');
                    $wrapper.removeClass('sidebar-hidden');
                } else {
                    $sidebar.addClass('collapsed');
                    $wrapper.addClass('sidebar-hidden');
                }
            }
        });

        // Close the sidebar when click the background (mobile)
        $backdrop.on('click', function () {
            $sidebar.removeClass('mobile-open');
            $backdrop.removeClass('show');
        });

        // When resizing: reset mobile ↔ desktop state
        $(window).on('resize', function () {
            if (!isMobile()) {
                $sidebar.removeClass('mobile-open');
                $backdrop.removeClass('show');
            }
        });


        /* =====================================================
           LOGOUT — SweetAlert2 Confirmation
        ===================================================== */
        $('#btnLogout').on('click', function (e) {
            e.preventDefault();
            const logoutUrl = $(this).attr('href');

            Swal.fire({
                title: 'Log Out?',
                text: 'Your session is about to end. Please make sure all your work has been saved.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f05252',
                cancelButtonColor:  '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-right-from-bracket me-1"></i> Logout',
                cancelButtonText:  'Cancel',
                reverseButtons: true,
                backdrop: true,
                customClass: {
                    popup: 'swal2-popup',
                }
            }).then(function (result) {
                if (result.isConfirmed) {
                    // CSRF-aware redirect (Use a POST form if necessary)
                    window.location.href = logoutUrl;
                }
            });
        });


        /* =====================================================
           GLOBAL FLASH MESSAGE (optional)
           Use on the controller: session()->flash('swal', [...])
        ===================================================== */
        @if(session('swal'))
            var swalData = @json(session('swal'));
            Swal.fire(swalData);
        @endif

    }); // end document.ready
</script>