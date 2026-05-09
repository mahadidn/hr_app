{{-- Sidebar Backdrop (mobile) --}}
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

{{-- ===================== SIDEBAR ===================== --}}
<aside class="sidebar" id="mainSidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-logo">
            <i class="fa-solid fa-hexagon-nodes"></i>
        </div>
        <div class="brand-text">
            <span class="brand-name">HR App</span>
            <span class="brand-tagline">Enterprise</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <div class="nav-section-label">Main Menu</div>

        <a href="{{ url('/dashboard') }}"
           class="nav-item-link {{ request()->is('dashboard*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
            <span>Dashboard</span>
        </a>

        <a href="{{ url('/departments') }}"
           class="nav-item-link {{ request()->is('departments*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-building"></i></span>
            <span>Departments</span>
        </a>

        <a href="{{ url('/employees') }}"
           class="nav-item-link {{ request()->is('employees*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
            <span>Employees</span>
            <span class="nav-badge">124</span>
            </a>

        <a href="{{ url('/attendance') }}"
           class="nav-item-link {{ request()->is('attendance*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
            <span>Attendance</span>
        </a>
    </nav>

    {{-- Footer (Logout) --}}
    
    <div class="sidebar-footer">
        <form action="{{ url('/logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="button" class="nav-item-link" id="btnLogout" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                <span class="nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>
{{-- END SIDEBAR --}}