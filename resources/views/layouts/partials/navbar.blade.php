{{-- ===================== NAVBAR ===================== --}}
<header class="top-navbar">

    {{-- Toggle sidebar --}}
    <button class="btn-sidebar-toggle" id="btnToggleSidebar" title="Toggle Sidebar">
        <i class="fa-solid fa-bars"></i>
    </button>

    {{-- Breadcrumb / Page title --}}
    <div class="navbar-breadcrumb">
        <i class="fa-solid fa-house" style="font-size:12px;"></i>
        <span style="font-size:11px;">/</span>
        <span class="page-title">@yield('page_title', 'Dashboard')</span>
    </div>

    {{-- Right group --}}
    <div class="navbar-right">

        {{-- Search --}}
        <button class="btn-nav-icon" title="Search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

        {{-- Notifications --}}
        <button class="btn-nav-icon" title="Notifications">
            <i class="fa-solid fa-bell"></i>
            <span class="notif-dot"></span>
        </button>

        <div class="navbar-divider"></div>

        {{-- Dark Mode Toggle --}}
        <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode" aria-label="Toggle theme">
            <div class="theme-toggle-thumb" id="themeThumb">
                <i class="fa-solid fa-sun" id="themeIcon"></i>
            </div>
        </button>

        <div class="navbar-divider d-none d-sm-block"></div>

        {{-- User --}}
        <div class="navbar-user" title="HR Admin">
            <div class="user-avatar">HA</div>
            <div class="user-info">
                <span class="user-name">HR Admin</span>
                <span class="user-role">Administrator</span>
            </div>
            <i class="fa-solid fa-chevron-down" style="font-size:10px;color:var(--text-muted);margin-left:2px;"></i>
        </div>

    </div>
</header>
{{-- END NAVBAR --}}