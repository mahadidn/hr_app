@extends('layouts.app')

@section('title', 'Employee Management')
@section('page_title', 'Employee Management')

{{-- ================================================================
     PAGE CSS
================================================================ --}}
@section('css')
    <link href="{{ asset('css/employee.css') }}" rel="stylesheet">
@endsection


{{-- ================================================================
     CONTENT
================================================================ --}}
@section('content')

    {{-- ============ PAGE HEADER ============ --}}
    <div class="emp-page-header">
        <div class="emp-heading-group">
            <div class="emp-eyebrow">
                <span class="pulse-dot"></span>
                Master Data
            </div>
            <h1 class="emp-heading">Employee Management</h1>
            <p class="emp-subheading">Manage all data on the company's active employees.</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <button class="btn-primary-emp" id="btnAddEmployee"
                    data-bs-toggle="modal" data-bs-target="#modalAddEmployee">
                <i class="fa-solid fa-plus"></i> Add New Employee
            </button>
        </div>
    </div>

    {{-- ============ STATS MINI ROW ============ --}}
    <div class="stats-row mb-3">
        <div class="stat-chip-mini">
            <span class="chip-dot" style="background:#4f6ef7;"></span>
            Total Employees: <strong>2,418</strong>
        </div>
    </div>

    {{-- ============ FILTER & SEARCH ============ --}}
    <div class="filter-card">
        <div class="filter-row">

            {{-- Left: Filter by Department --}}
            <div class="filter-field">
                <span class="filter-label"><i class="fa-solid fa-building me-1"></i> Filter by Department</span>
                <select class="emp-form-select" id="filterDept">
                    <option value="">All Departments</option>
                    @foreach ($departments as $index => $dept)
                        <option value="{{$dept->Dept_name}}">{{$dept->Dept_name}}</option>
                    @endforeach
                </select>
            </div>

            

            {{-- Right: Search --}}
            <div class="filter-field search-field" style="flex:1;">
                <span class="filter-label"><i class="fa-solid fa-magnifying-glass me-1"></i> Search Employee</span>
                <div style="position:relative;">
                    <i class="fa-solid fa-magnifying-glass s-icon" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px;pointer-events:none;"></i>
                    <input type="text" class="emp-form-input" id="searchEmp"
                           placeholder="Search NIK or Name…"
                           style="padding-left:38px;width:100%;">
                </div>
            </div>

            {{-- Actions --}}
            <div class="filter-actions" style="align-self:flex-end;">
                <button class="btn-primary-emp" id="btnApplyFilter" style="padding:9px 18px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                <button class="btn-secondary-emp" id="btnResetFilter">
                    <i class="fa-solid fa-xmark"></i> Reset
                </button>
            </div>

        </div>
    </div>

    {{-- ============ TABLE CARD ============ --}}
    <div class="table-card">

        <div class="table-card-header">
            <div class="table-card-title">
                <i class="fa-solid fa-users" style="color:var(--accent-text);font-size:16px;"></i>
                Daftar Karyawan
                <span class="title-pill" id="rowCountPill">2,418 records</span>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button class="btn-secondary-emp" style="padding:7px 14px;font-size:12px;">
                    <i class="fa-solid fa-rotate-right"></i> Refresh
                </button>
                <button class="btn-secondary-emp" style="padding:7px 14px;font-size:12px;">
                    <i class="fa-solid fa-sliders"></i> Columns
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="emp-table" id="empTable">
                <thead>
                    <tr>
                        <th style="width:44px;padding-left:20px;">
                            <input type="checkbox" id="checkAll" style="accent-color:var(--accent);width:15px;height:15px;">
                        </th>
                        <th class="sortable" data-col="nik">NIK <i class="fa-solid fa-sort sort-icon"></i></th>
                        <th class="sortable" data-col="name">Name <i class="fa-solid fa-sort sort-icon"></i></th>
                        <th class="sortable" data-col="dept">Department <i class="fa-solid fa-sort sort-icon"></i></th>
                        <th class="sortable" data-col="desig">Designation <i class="fa-solid fa-sort sort-icon"></i></th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="empTbody">
                    @forelse($employees as $emp)
                        @php
                            // Buat inisial (Contoh: Ahmad Wijaya -> AW)
                            $words = explode(' ', $emp->Full_name);
                            $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            
                            // Generate warna gradien unik berdasarkan ID untuk Avatar
                            $grad = 'linear-gradient(135deg, #4f6ef7, #7c3aed)'; 
                        @endphp
                        
                        <tr data-id="{{ $emp->id }}"
                            data-nik="{{ $emp->NIK }}"
                            data-name="{{ $emp->Full_name }}"
                            data-dept="{{ $emp->Dept_id }}" {{-- Value department_id untuk select edit --}}
                            data-dept-name="{{ $emp->department->Dept_name ?? 'N/A' }}"
                            data-desig="{{ $emp->Designation }}"
                            data-gender="{{ $emp->Gender }}"
                            data-phone="{{ $emp->Phone_no }}"
                            data-join="{{ $emp->Join_date }}"
                            data-join-end="{{ $emp->Join_end }}"
                            data-birth-place="{{ $emp->Birth_place }}"
                            data-birth-date="{{ $emp->Birth_date }}"
                            data-grad="{{ $grad }}"
                            data-initials="{{ $initials }}"
                            data-dept-color="#4f6ef7">
                            
                            <td style="padding-left:20px;">
                                <input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;">
                            </td>
                            <td><span class="nik-badge">{{ $emp->NIK }}</span></td>
                            <td>
                                <div class="emp-cell">
                                    <div class="emp-avatar" style="background:{{ $grad }};">{{ $initials }}</div>
                                    <div>
                                        <div class="emp-name">{{ $emp->Full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="dept-badge">
                                    <span class="dept-dot" style="background:#4f6ef7;"></span>
                                    {{ $emp->department->Dept_name ?? 'N/A' }} {{-- Panggil relasi dari Controller --}}
                                </span>
                            </td>
                            <td><span class="desig-text">{{ $emp->Designation }}</span></td>
                            <td style="text-align:center;">
                                <div class="action-group" style="justify-content:center;">
                                    <button class="btn-act btn-act-view"
                                            title="View Detail"
                                            data-action="view"
                                            data-row-id="{{ $emp->id }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button class="btn-act btn-act-edit"
                                            title="Edit Employee"
                                            data-action="edit"
                                            data-row-id="{{ $emp->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn-act btn-act-del"
                                            title="Delete Employee"
                                            data-action="delete"
                                            data-row-id="{{ $emp->id }}"
                                            data-name="{{ $emp->Full_name }}"
                                            data-nik="{{ $emp->NIK }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data karyawan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="table-footer">
            <div class="table-info">
                Menampilkan <strong id="showFrom">1</strong>–<strong id="showTo">7</strong>
                dari <strong id="showTotal">7</strong> karyawan
            </div>
            <div class="pagination-wrap">
                <button class="pg-btn"><i class="fa-solid fa-chevron-left" style="font-size:10px;"></i></button>
                <button class="pg-btn active">1</button>
                <button class="pg-btn">2</button>
                <button class="pg-btn">3</button>
                <span style="display:flex;align-items:center;padding:0 4px;color:var(--text-muted);font-size:12px;">…</span>
                <button class="pg-btn">345</button>
                <button class="pg-btn"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></button>
            </div>
        </div>

    </div>
    {{-- END TABLE CARD --}}


    {{-- ================================================================
         MODAL: ADD NEW EMPLOYEE
    ================================================================ --}}
    <div class="modal fade emp-modal" id="modalAddEmployee" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="modal-title-icon"><i class="fa-solid fa-user-plus"></i></span>
                        Add New Employee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ url('/employees') }}" method="POST" id="formAddEmployee" novalidate>
                        @csrf

                        {{-- Section 1: Identity --}}
                        <div class="form-section-title">
                            <i class="fa-solid fa-id-card"></i> Data Identitas
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="f-label">NIK <span class="req">*</span></label>
                                <input type="text" class="f-input" name="NIK" id="addNik"
                                       maxlength="13" placeholder="Contoh: 1001-ENG-2024" required>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Full Name <span class="req">*</span></label>
                                <input type="text" class="f-input" name="Full_name" id="addFullName"
                                       maxlength="50" placeholder="Nama lengkap karyawan" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="f-label">Department <span class="req">*</span></label>
                                {{-- Custom searchable dropdown --}}
                                <div class="dept-dropdown-wrap" id="addDeptWrap">
                                    <div class="dept-dropdown-display" id="addDeptDisplay">
                                        <span class="dd-label dd-placeholder">Pilih Departemen…</span>
                                        <i class="fa-solid fa-chevron-down dd-arrow"></i>
                                    </div>
                                    <div class="dept-dropdown-menu" id="addDeptMenu">
                                        <div class="dept-search-wrap">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" class="dept-search-input" id="addDeptSearch" placeholder="Cari departemen…">
                                        </div>
                                        <div class="dept-option-list" id="addDeptList">
                                            {{-- Rendered by JS --}}
                                        </div>
                                    </div>
                                    <input type="hidden" name="Dept_id" id="addDeptHidden" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Designation <span class="req">*</span></label>
                                <input type="text" class="f-input" name="Designation" id="addDesignation"
                                       maxlength="50" placeholder="Jabatan / posisi" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="f-label">Gender <span class="req">*</span></label>
                                <select class="f-select" name="Gender" id="addGender" required>
                                    <option value="" disabled selected>Pilih gender…</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Phone No</label>
                                <input type="text" class="f-input" name="Phone_no" id="addPhone"
                                       maxlength="13" placeholder="+62 8xx-xxxx-xxxx">
                            </div>
                        </div>

                        {{-- Section 2: Personal Data --}}
                        <div class="form-section-title">
                            <i class="fa-solid fa-cake-candles"></i> Data Personal
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="f-label">Birth Place <span class="req">*</span></label>
                                <input type="text" class="f-input" name="Birth_place" id="addBirthPlace"
                                       maxlength="50" placeholder="Kota kelahiran" required>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Birth Date <span class="req">*</span></label>
                                <input type="date" class="f-input" name="Birth_date" id="addBirthDate" required>
                            </div>
                        </div>

                        {{-- Section 3: Employment --}}
                        <div class="form-section-title">
                            <i class="fa-solid fa-briefcase"></i> Data Kepegawaian
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="f-label">Join Date <span class="req">*</span></label>
                                <input type="date" class="f-input" name="Join_date" id="addJoinDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Join End
                                    <span style="color:var(--text-muted);font-weight:400;">(opsional)</span>
                                </label>
                                <input type="date" class="f-input" name="Join_end" id="addJoinEnd">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer" style="justify-content:space-between;">
                    <span style="font-size:12px;color:var(--text-muted);">
                        <i class="fa-solid fa-circle-info me-1"></i> Kolom bertanda <span style="color:#f05252;font-weight:700;">*</span> wajib diisi.
                    </span>
                    <div style="display:flex;gap:10px;">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Batal
                        </button>
                        <button type="button" class="btn-modal-save" id="btnSaveEmployee">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Karyawan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- END MODAL ADD --}}


    {{-- ================================================================
         MODAL: EDIT EMPLOYEE
    ================================================================ --}}
    <div class="modal fade emp-modal" id="modalEditEmployee" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header" style="background:linear-gradient(135deg,rgba(245,158,11,.1),var(--bg-card));">
                    <h5 class="modal-title">
                        <span class="modal-title-icon" style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </span>
                        Edit Employee
                        <span style="font-size:12px;font-weight:500;color:var(--text-muted);margin-left:4px;" id="editModalNikLabel"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="modal-body">
                    <form id="formEditEmployee" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editEmpId" name="id">

                        <div class="form-section-title"><i class="fa-solid fa-id-card"></i> Identification Information</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="f-label">NIK <span class="req">*</span></label>
                                <input type="text" class="f-input" name="NIK" id="editNik" maxlength="13" required>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Full Name <span class="req">*</span></label>
                                <input type="text" class="f-input" name="Full_name" id="editFullName" maxlength="50" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="f-label">Department <span class="req">*</span></label>
                                <div class="dept-dropdown-wrap" id="editDeptWrap">
                                    <div class="dept-dropdown-display" id="editDeptDisplay">
                                        <span class="dd-label dd-placeholder">Select a Department…</span>
                                        <i class="fa-solid fa-chevron-down dd-arrow"></i>
                                    </div>
                                    <div class="dept-dropdown-menu" id="editDeptMenu">
                                        <div class="dept-search-wrap">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" class="dept-search-input" id="editDeptSearch" placeholder="Cari departemen…">
                                        </div>
                                        <div class="dept-option-list" id="editDeptList"></div>
                                    </div>
                                    <input type="hidden" name="Dept_id" id="editDeptHidden" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Designation <span class="req">*</span></label>
                                <input type="text" class="f-input" name="Designation" id="editDesignation" maxlength="50" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="f-label">Gender <span class="req">*</span></label>
                                <select class="f-select" name="Gender" id="editGender" required>
                                    <option value="" disabled>Pilih gender…</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Phone No</label>
                                <input type="text" class="f-input" name="Phone_no" id="editPhone" maxlength="13">
                            </div>
                        </div>

                        <div class="form-section-title"><i class="fa-solid fa-cake-candles"></i> Data Personal</div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="f-label">Birth Place <span class="req">*</span></label>
                                <input type="text" class="f-input" name="Birth_place" id="editBirthPlace" maxlength="50" required>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Birth Date <span class="req">*</span></label>
                                <input type="date" class="f-input" name="Birth_date" id="editBirthDate" required>
                            </div>
                        </div>

                        <div class="form-section-title"><i class="fa-solid fa-briefcase"></i> Data Kepegawaian</div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="f-label">Join Date <span class="req">*</span></label>
                                <input type="date" class="f-input" name="Join_date" id="editJoinDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="f-label">Join End</label>
                                <input type="date" class="f-input" name="Join_end" id="editJoinEnd">
                            </div>
                        </div>

                    </form>
                </div>

                <div class="modal-footer" style="justify-content:space-between;">
                    <span style="font-size:12px;color:var(--text-muted);">
                        <i class="fa-solid fa-circle-info me-1"></i> Fields marked with an <span style="color:#f05252;font-weight:700;">*</span> are required.
                    </span>
                    <div style="display:flex;gap:10px;">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                        <button type="button" class="btn-modal-save" id="btnUpdateEmployee"
                                style="background:linear-gradient(135deg,#f59e0b,#ef4444);box-shadow:0 4px 12px rgba(245,158,11,.35);">
                            <i class="fa-solid fa-floppy-disk"></i> Update Employee
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- END MODAL EDIT --}}


    {{-- ================================================================
         MODAL: VIEW EMPLOYEE DETAIL
    ================================================================ --}}
    <div class="modal fade emp-modal" id="modalViewEmployee" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header" style="background:linear-gradient(135deg,rgba(14,166,110,.08),var(--bg-card));">
                    <h5 class="modal-title">
                        <span class="modal-title-icon" style="background:linear-gradient(135deg,#0ea66e,#0284c7);">
                            <i class="fa-solid fa-address-card"></i>
                        </span>
                        Employee Detail
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <div class="modal-body">

                    {{-- Employee Card Header --}}
                    <div class="view-emp-header">
                        <div class="view-emp-avatar" id="viewEmpAvatar" style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);">
                            AW
                        </div>
                        <div>
                            <div class="view-emp-name" id="viewEmpName">—</div>
                            <div class="view-emp-desig" id="viewEmpDesig">—</div>
                            <div class="view-emp-tags">
                                <span class="dept-badge" id="viewEmpDeptBadge">
                                    <span class="dept-dot" id="viewDeptDot" style="background:#4f6ef7;"></span>
                                    <span id="viewEmpDept">—</span>
                                </span>
                                <span class="gender-badge" id="viewEmpGenderBadge" style="font-size:11.5px;">—</span>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Grid --}}
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-item-label"><i class="fa-solid fa-hashtag me-1"></i> NIK</div>
                            <div class="detail-item-val mono" id="viewNik">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-item-label"><i class="fa-solid fa-phone me-1"></i> Phone No</div>
                            <div class="detail-item-val mono" id="viewPhone">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-item-label"><i class="fa-solid fa-location-dot me-1"></i> Birth Place</div>
                            <div class="detail-item-val" id="viewBirthPlace">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-item-label"><i class="fa-solid fa-cake-candles me-1"></i> Birth Date</div>
                            <div class="detail-item-val" id="viewBirthDate">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-item-label"><i class="fa-solid fa-calendar-plus me-1"></i> Join Date</div>
                            <div class="detail-item-val" id="viewJoinDate">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-item-label"><i class="fa-solid fa-calendar-xmark me-1"></i> Join End</div>
                            <div class="detail-item-val" id="viewJoinEnd">—</div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i> Tutup
                    </button>
                    <button type="button" class="btn-modal-edit" id="btnViewToEdit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Data
                    </button>
                </div>

            </div>
        </div>
    </div>
    {{-- END MODAL VIEW --}}

@endsection


{{-- ================================================================
     SCRIPTS
================================================================ --}}
@section('scripts')
<script>
$(function () {

    /* ================================================================
       DEPARTMENT DATA
    ================================================================ */
    @php
        // Palet warna departemen (opsional)
        $deptColors = ['#4f6ef7','#0ea66e','#f59e0b','#0284c7','#7c3aed','#db2777','#64748b','#ef4444','#8b5cf6','#06b6d4'];
    @endphp
    var departments = [
        @foreach($departments as $index => $dept)
            { 
                value: '{{ $dept->id }}', 
                label: '{{ $dept->Dept_name }}', 
                color: '{{ $deptColors[$index % count($deptColors)] }}' 
            },
        @endforeach
    ];


    /* ================================================================
       SEARCHABLE DEPARTMENT DROPDOWN — factory function
    ================================================================ */
    function initDeptDropdown(opts) {
        var $display  = $(opts.display);
        var $menu     = $(opts.menu);
        var $search   = $(opts.search);
        var $list     = $(opts.list);
        var $hidden   = $(opts.hidden);
        var selected  = opts.initial || '';

        function renderOptions(filter) {
            $list.empty();
            var filtered = filter
                ? departments.filter(function(d) {
                    return d.label.toLowerCase().includes(filter.toLowerCase());
                  })
                : departments;

            if (filtered.length === 0) {
                $list.html('<div class="dept-no-result"><i class="fa-solid fa-circle-info me-1"></i>Tidak ditemukan</div>');
                return;
            }

            filtered.forEach(function(d) {
                var isSelected = (d.value === selected);
                $list.append(
                    '<div class="dept-option' + (isSelected ? ' selected' : '') + '" data-value="' + d.value + '">' +
                    '<span class="dept-color-dot" style="background:' + d.color + ';"></span>' +
                    d.label +
                    '<i class="fa-solid fa-check check-icon"></i>' +
                    '</div>'
                );
            });
        }

        function setSelected(val, label) {
            selected = val;
            $hidden.val(val);
            $display.html(
                '<span class="dd-label">' + label + '</span>' +
                '<i class="fa-solid fa-chevron-down dd-arrow"></i>'
            );
            if ($display.hasClass('open')) closeMenu();
        }

        function openMenu() {
            $display.addClass('open');
            $menu.addClass('open');
            $search.val('').trigger('input').focus();
        }

        function closeMenu() {
            $display.removeClass('open');
            $menu.removeClass('open');
        }

        // Initial render
        renderOptions('');
        if (selected) {
            var initDept = departments.find(function(d){ return d.value === selected; });
            if (initDept) setSelected(initDept.value, initDept.label);
        }

        // Toggle open
        $display.on('click', function(e) {
            e.stopPropagation();
            $display.hasClass('open') ? closeMenu() : openMenu();
        });

        // Live search
        $search.on('input', function() {
            renderOptions($(this).val().trim());
        });

        // Select option
        $list.on('click', '.dept-option', function() {
            var val = $(this).data('value');
            var d = departments.find(function(dept) { return dept.value == val; });
            if (d) setSelected(d.value, d.label);  // ← label diambil dari array
        });

        // Close on outside click
        $(document).on('click.deptdd' + opts.id, function() { closeMenu(); });

        $menu.on('click', function(e) { e.stopPropagation(); });

        // Expose method to set value programmatically
        return {
            setValue: function(val) {
                var d = departments.find(function(d){ return d.value === val; });
                if (d) setSelected(d.value, d.label);
                else { selected=''; $hidden.val(''); $display.html('<span class="dd-label dd-placeholder">Pilih Departemen…</span><i class="fa-solid fa-chevron-down dd-arrow"></i>'); }
            },
            reset: function() { this.setValue(''); renderOptions(''); }
        };
    }

    // Init both dropdowns
    var addDeptDD  = initDeptDropdown({ id:'add',  display:'#addDeptDisplay',  menu:'#addDeptMenu',  search:'#addDeptSearch',  list:'#addDeptList',  hidden:'#addDeptHidden' });
    var editDeptDD = initDeptDropdown({ id:'edit', display:'#editDeptDisplay', menu:'#editDeptMenu', search:'#editDeptSearch', list:'#editDeptList', hidden:'#editDeptHidden' });


    /* ================================================================
       FILTER & SEARCH
    ================================================================ */
    function applyFilters() {
        var dept    = $('#filterDept').val().toLowerCase();
        var keyword = $('#searchEmp').val().trim().toLowerCase();
        var visible = 0;

        $('#empTbody tr').each(function() {
            var name  = $(this).find('.emp-name').text().toLowerCase();
            var nik   = $(this).find('.nik-badge').text().toLowerCase();
            var dText = $(this).find('.dept-badge').text().trim().toLowerCase();
            var gText = $(this).find('.gender-badge').text().trim().toLowerCase();

            var mDept   = !dept    || dText.includes(dept);
            var mKw     = !keyword || name.includes(keyword) || nik.includes(keyword);

            var show = mDept && mKw;
            $(this).toggle(show);
            if (show) visible++;
        });

        $('#showFrom').text(visible ? 1 : 0);
        $('#showTo').text(visible);
        $('#showTotal').text(visible);
        $('#rowCountPill').text(visible + ' records');
    }

    $('#btnApplyFilter').on('click', applyFilters);
    $('#searchEmp').on('keyup', applyFilters);
    $('#filterDept').on('change', applyFilters);

    $('#btnResetFilter').on('click', function() {
        $('#filterDept').val('');
        $('#searchEmp').val('');
        $('#empTbody tr').show();
        $('#showFrom').text(1);
        $('#showTo').text(7);
        $('#showTotal').text(7);
        $('#rowCountPill').text('2,418 records');
    });

    // Check-all
    $('#checkAll').on('change', function() {
        $('.row-check').prop('checked', $(this).is(':checked'));
    });

    // Sortable columns
    var sortState = {};
    $('.emp-table thead th.sortable').on('click', function() {
        var col = $(this).data('col');
        var asc = sortState[col] !== 'asc';
        sortState[col] = asc ? 'asc' : 'desc';
        $('.emp-table thead th').removeClass('sort-asc sort-desc')
            .find('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
        $(this).addClass(asc ? 'sort-asc' : 'sort-desc')
               .find('.sort-icon').removeClass('fa-sort').addClass(asc ? 'fa-sort-up' : 'fa-sort-down');
    });


    /* ================================================================
       VIEW MODAL — populate from data-* attributes
    ================================================================ */
    var currentViewRow = null;

    $(document).on('click', '[data-action="view"]', function() {
        var $row = $(this).closest('tr');
        currentViewRow = $row;

        var name       = $row.data('name');
        var nik        = $row.data('nik');
        var dept       = $row.data('dept');
        var deptName  = $row.data('dept-name');
        var desig      = $row.data('desig');
        var gender     = $row.data('gender');
        var phone      = $row.data('phone');
        var joinDate   = $row.data('join');
        var joinEnd    = $row.data('join-end');
        var birthPlace = $row.data('birth-place');
        var birthDate  = $row.data('birth-date');
        var grad       = $row.data('grad');
        var initials   = $row.data('initials');
        var deptColor  = $row.data('dept-color');

        // Populate modal
        $('#viewEmpAvatar').html(initials).attr('style', 'background:' + grad + ';');
        $('#viewEmpName').text(name);
        $('#viewEmpDesig').text(desig);
        // $('#viewEmpDept').text(dept);
        $('#viewEmpDept').text(deptName);
        $('#viewDeptDot').css('background', deptColor);
        $('#viewNik').text(nik);
        $('#viewPhone').text(phone || '—');
        $('#viewBirthPlace').text(birthPlace || '—');
        $('#viewBirthDate').text(birthDate ? formatDate(birthDate) : '—');
        $('#viewJoinDate').text(joinDate ? formatDate(joinDate) : '—');
        $('#viewJoinEnd').text(joinEnd ? formatDate(joinEnd) : '—');

        if (gender === 'Male') {
            $('#viewEmpGenderBadge')
                .attr('class', 'gender-badge gender-m')
                .html('<i class="fa-solid fa-mars" style="font-size:11px;"></i> Male');
        } else {
            $('#viewEmpGenderBadge')
                .attr('class', 'gender-badge gender-f')
                .html('<i class="fa-solid fa-venus" style="font-size:11px;"></i> Female');
        }

        var viewModal = new bootstrap.Modal(document.getElementById('modalViewEmployee'));
        viewModal.show();
    });

    // "Edit Data" button inside view modal
    $('#btnViewToEdit').on('click', function() {
        bootstrap.Modal.getInstance(document.getElementById('modalViewEmployee')).hide();
        if (currentViewRow) {
            setTimeout(function() {
                currentViewRow.find('[data-action="edit"]').trigger('click');
            }, 300);
        }
    });


    /* ================================================================
       EDIT MODAL — populate fields from row data
    ================================================================ */
    $(document).on('click', '[data-action="edit"]', function() {
        var $row = $(this).closest('tr');

        var id         = $row.data('id');
        var nik        = $row.data('nik');
        var name       = $row.data('name');
        var dept       = $row.data('dept');
        var desig      = $row.data('desig');
        var gender     = $row.data('gender');
        var phone      = $row.data('phone');
        var joinDate   = $row.data('join');
        var joinEnd    = $row.data('join-end');
        var birthPlace = $row.data('birth-place');
        var birthDate  = $row.data('birth-date');

        // Populate form
        $('#editEmpId').val(id);
        $('#editNik').val(nik);
        $('#editFullName').val(name);
        $('#editDesignation').val(desig);
        $('#editGender').val(gender);
        $('#editPhone').val(phone);
        $('#editBirthPlace').val(birthPlace);
        $('#editBirthDate').val(birthDate);
        $('#editJoinDate').val(joinDate);
        $('#editJoinEnd').val(joinEnd || '');
        $('#editModalNikLabel').text('— ' + nik);

        // Set searchable dept dropdown
        editDeptDD.setValue(dept);

        var editModal = new bootstrap.Modal(document.getElementById('modalEditEmployee'));
        editModal.show();
    });


    /* ================================================================
       FORM VALIDATION HELPER
    ================================================================ */
    function validateForm(formSelector, deptHiddenId) {
        var valid = true;
        $(formSelector + ' .f-input[required], ' + formSelector + ' .f-select[required]').each(function() {
            $(this).removeClass('is-invalid');
            if (!$.trim($(this).val())) {
                $(this).addClass('is-invalid');
                valid = false;
            }
        });
        // Validate dept dropdown
        var deptVal = $(deptHiddenId).val();
        if (!deptVal) {
            $(formSelector).find('.dept-dropdown-display').css('border-color','#f05252');
            valid = false;
        } else {
            $(formSelector).find('.dept-dropdown-display').css('border-color','');
        }
        return valid;
    }


    /* ================================================================
       SAVE NEW EMPLOYEE
    ================================================================ */
    $('#btnSaveEmployee').on('click', function() {
        // Front-end validation
        if (!validateForm('#formAddEmployee', '#addDeptHidden')) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Not Complete',
                text: 'Please fill in all required fields.',
                confirmButtonColor: '#4f6ef7'
            });
            return;
        }

        // display the Loading
        Swal.fire({
            title: 'Saving Data…',
            html: 'Saving new employee data.',
            allowOutsideClick: false,
            didOpen: function() { Swal.showLoading(); }
        });

        // Send the data via AJAX
        $.ajax({
            url: $('#formAddEmployee').attr('action'), // Automatically trigger an action from the form tag
            method: 'POST',
            data: $('#formAddEmployee').serialize(), // Automatically wrap all form inputs
            success: function(response) {
                // If successfully saved to the database
                Swal.fire({
                    icon: 'success',
                    title: 'Successfully Added!',
                    html: '<strong>' + $('#addFullName').val() + "</strong>'s employee has been successfully saved.",
                    confirmButtonColor: '#4f6ef7',
                    confirmButtonText: 'OK'
                }).then(function() {
                    // Close & Reset Form
                    bootstrap.Modal.getInstance(document.getElementById('modalAddEmployee')).hide();
                    $('#formAddEmployee')[0].reset();
                    addDeptDD.reset();
                    
                    // Refresh the page to see the latest data in the table
                    window.location.reload(); 
                });
            },
            error: function(xhr) {

                var errorMsg = 'An error occurred while saving the data.';
                
                // catch error message detail from laravel
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors)[0][0]; 
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Failed to Save',
                    text: errorMsg,
                    confirmButtonColor: '#f05252'
                });
            }
        });
    });

    // Reset form when Add modal closes
    document.getElementById('modalAddEmployee').addEventListener('hidden.bs.modal', function() {
        $('#formAddEmployee')[0].reset();
        $('#formAddEmployee .f-input, #formAddEmployee .f-select').removeClass('is-invalid');
        $('#formAddEmployee .dept-dropdown-display').css('border-color','');
        addDeptDD.reset();
    });


    /* ================================================================
       UPDATE EMPLOYEE
    ================================================================ */
    $('#btnUpdateEmployee').on('click', function() {
        // 1. Validasi Front-end
        if (!validateForm('#formEditEmployee', '#editDeptHidden')) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Not Complete',
                text: 'Please fill in all required fields.',
                confirmButtonColor: '#4f6ef7'
            });
            return;
        }

        // Get the Employee ID to generate a dynamic URL
        var empId = $('#editEmpId').val();
        var targetUrl = '{{ url("/employees") }}/' + empId;

        // display Loading
        Swal.fire({
            title: 'Updating data…',
            html: 'Saving changes.',
            allowOutsideClick: false,
            didOpen: function() { Swal.showLoading(); }
        });

        // send request to AJAX
        $.ajax({
            url: targetUrl,
            method: 'POST', // Continue to use POST because @method('PUT') is automatically included in .serialize()
            data: $('#formEditEmployee').serialize(),
            success: function(response) {
                // if success
                Swal.fire({
                    icon: 'success',
                    title: 'Data Updated!',
                    html: '<strong>' + $('#editFullName').val() + "</strong>'s employee information has been successfully updated.",
                    confirmButtonColor: '#4f6ef7'
                }).then(function() {
                    bootstrap.Modal.getInstance(document.getElementById('modalEditEmployee')).hide();
                    window.location.reload(); 
                });
            },
            error: function(xhr) {
                var errorMsg = 'Terjadi kesalahan saat memperbarui data.';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors)[0][0]; 
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memperbarui',
                    text: errorMsg,
                    confirmButtonColor: '#f05252'
                });
            }
        });
    });


    /* ================================================================
       DELETE — SweetAlert2 Confirmation
    ================================================================ */
    $(document).on('click', '[data-action="delete"]', function() {
        var $btn = $(this);
        var name  = $btn.data('name');
        var nik   = $btn.data('nik');
        var id    = $btn.data('row-id');

        //  Confirmation
        Swal.fire({
            icon: 'warning',
            title: 'Delete Employee?',
            html:
                'You are about to delete this data:<br>' +
                '<strong style="font-size:15px;">' + name + '</strong><br>' +
                '<span style="font-family:monospace;font-size:12px;color:#888;">' + nik + '</span>' +
                '<br><br>' +
                '<span style="font-size:13px;color:#e53e3e;"><u>This action cannot be undone and will also delete all attendance records for this employee</u>.</span>',
            showCancelButton: true,
            confirmButtonColor: '#f05252',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> Yes',
            cancelButtonText: '<i class="fa-solid fa-xmark me-1"></i> Cancel',
            reverseButtons: true,
            focusCancel: true,
        }).then(function(result) {
            if (!result.isConfirmed) return;

            // Loading indicator
            Swal.fire({
                title: 'Deleting data…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function() { Swal.showLoading(); }
            });

            //  AJAX Request to the Laravel Backend
            $.ajax({
                url: '{{ url("/employees") }}/' + id, 
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var $row = $('[data-action="delete"][data-row-id="' + id + '"]').closest('tr');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success Deleted',
                        html: 'The employee data has been <strong>' + name + '</strong> successfully deleted from system.',
                        confirmButtonColor: '#4f6ef7',
                        timer: 2800, 
                        timerProgressBar: true,
                        showConfirmButton: false
                    });

                    $row.css({ transition: 'opacity .35s ease, transform .35s ease', opacity: 0, transform: 'translateX(20px)' });
                    setTimeout(function() { 
                        $row.remove(); 
                    }, 380);
                },
                error: function(xhr) {
                    
                    var errorMsg = 'An error occurred while deleting the data. Please try again.';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Delete',
                        text: errorMsg,
                        confirmButtonColor: '#f05252'
                    });
                }
            });
        });
    });


    /* ================================================================
       UTILITY — Format date YYYY-MM-DD → DD Month YYYY (ID)
    ================================================================ */
    function formatDate(dateStr) {
        if (!dateStr) return '—';
        var months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        var parts = dateStr.split('-');
        if (parts.length !== 3) return dateStr;
        return parseInt(parts[2]) + ' ' + months[parseInt(parts[1]) - 1] + ' ' + parts[0];
    }

    /* ================================================================
       FLASH MESSAGE from session (Blade directive)
    ================================================================ */
    @if(session('swal'))
        Swal.fire(@json(session('swal')));
    @endif

});
</script>
@endsection