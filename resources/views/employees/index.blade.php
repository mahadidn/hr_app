@extends('layouts.app')

@section('title', 'Employee Management')
@section('page_title', 'Employee Management')

{{-- ================================================================
     PAGE CSS
================================================================ --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
@endsection


{{-- ================================================================
     CONTENT
================================================================ --}}
@section('content')

    {{-- ============ PAGE HEADER ============ --}}
    <div class="emp-page-header">
        <div>
            <div class="emp-eyebrow"><span class="pulse-dot"></span> Master Data</div>
            <h1 class="emp-heading">Employee Management</h1>
            <p class="emp-subheading">Kelola seluruh data karyawan perusahaan di satu tempat.</p>
        </div>
        <div class="header-chips">
            <div class="stat-chip">
                <i class="fa-solid fa-users" style="color:var(--accent-text);"></i>
                Total: <strong>2,418</strong>
            </div>
            <div class="stat-chip">
                <i class="fa-solid fa-user-check" style="color:#0ea66e;"></i>
                Aktif: <strong>2,390</strong>
            </div>
            <button class="btn-add-employee" data-bs-toggle="modal" data-bs-target="#modalAddEmployee">
                <i class="fa-solid fa-plus"></i> Add New Employee
            </button>
        </div>
    </div>

    {{-- ============ FILTER / SEARCH BAR ============ --}}
    <div class="filter-card">
        {{-- Department filter --}}
        <div class="filter-group">
            <span class="filter-label"><i class="fa-solid fa-building me-1"></i>Filter Departemen</span>
            <select class="filter-select" id="filterDept">
                <option value="">Semua Departemen</option>
                <option value="IT">IT / Engineering</option>
                <option value="HRD">Human Resources</option>
                <option value="FIN">Finance</option>
                <option value="MKT">Marketing</option>
                <option value="OPS">Operations</option>
                <option value="LEG">Legal</option>
                <option value="PRD">Product</option>
            </select>
        </div>


        {{-- Search --}}
        <div class="filter-group" style="flex:1;">
            <span class="filter-label"><i class="fa-solid fa-magnifying-glass me-1"></i>Cari Karyawan</span>
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" class="search-input" id="searchEmployee"
                       placeholder="Ketik NIK atau nama karyawan…">
            </div>
        </div>

        <div class="filter-actions">
            <button class="btn-filter primary" id="btnApplyFilter">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <button class="btn-filter secondary" id="btnResetFilter">
                <i class="fa-solid fa-xmark"></i> Reset
            </button>
        </div>
    </div>

    {{-- ============ TABLE CARD ============ --}}
    <div class="emp-card">

        <div class="emp-card-header">
            <div class="emp-card-title">
                <span class="title-icon"><i class="fa-solid fa-id-card"></i></span>
                Daftar Karyawan
                <span style="font-size:12px;font-weight:500;color:var(--text-muted);">— 2,418 records</span>
            </div>
            <div class="card-header-right">
                <button class="btn-card-action"><i class="fa-solid fa-rotate-right"></i> Refresh</button>
                <button class="btn-card-action"><i class="fa-solid fa-file-excel"></i> Export</button>
                <button class="btn-card-action"><i class="fa-solid fa-print"></i> Print</button>
            </div>
        </div>

        <div class="table-responsive-wrap">
            <table class="emp-table" id="employeeTable">
                <thead>
                    <tr>
                        <th class="th-check">
                            <input type="checkbox" id="checkAll"
                                   style="accent-color:var(--accent);width:15px;height:15px;">
                        </th>
                        <th class="th-num">#</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Tgl. Bergabung</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="employeeTbody">

                    {{-- Row 1 --}}
                    <tr data-dept="IT" data-gender="Male">
                        <td class="td-check"><input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;"></td>
                        <td class="td-num">1</td>
                        <td><span class="nik-mono">1001-ENG</span></td>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar" style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);">AW</div>
                                <div>
                                    <div class="emp-full-name">Ahmad Wijaya</div>
                                    <div class="emp-email">a.wijaya@nexahr.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="dept-badge" style="background:rgba(79,110,247,.1);color:var(--accent-text);"><span style="width:6px;height:6px;border-radius:50%;background:var(--accent);display:inline-block;"></span>IT / Engineering</span></td>
                        <td><span class="desig-text">Senior Backend Engineer</span></td>
                        <td style="font-size:12.5px;color:var(--text-secondary);">15 Jan 2020</td>
                        <td style="text-align:center;">
                            <div class="action-group">
                                <button class="btn-action view" title="View Detail"
                                    data-id="1" data-name="Ahmad Wijaya" data-nik="1001-ENG"
                                    data-dept="IT / Engineering" data-desig="Senior Backend Engineer"
                                    data-gender="Male" data-birth-place="Jakarta" data-birth-date="1992-04-10"
                                    data-phone="081234567890" data-join="2020-01-15" data-join-end="-"
                                    data-initials="AW" data-color="linear-gradient(135deg,#4f6ef7,#7c3aed)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit"
                                    data-id="1" data-name="Ahmad Wijaya" data-nik="1001-ENG"
                                    data-dept-val="IT" data-dept-label="IT / Engineering"
                                    data-desig="Senior Backend Engineer" data-gender="Male"
                                    data-birth-place="Jakarta" data-birth-date="1992-04-10"
                                    data-phone="081234567890" data-join="2020-01-15" data-join-end="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" title="Delete"
                                    data-id="1" data-name="Ahmad Wijaya" data-nik="1001-ENG">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr data-dept="HRD" data-gender="Female">
                        <td class="td-check"><input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;"></td>
                        <td class="td-num">2</td>
                        <td><span class="nik-mono">1045-HRD</span></td>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar" style="background:linear-gradient(135deg,#db2777,#f59e0b);">SR</div>
                                <div>
                                    <div class="emp-full-name">Sari Rahayu</div>
                                    <div class="emp-email">sari.r@nexahr.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="dept-badge" style="background:rgba(219,39,119,.1);color:#db2777;"><span style="width:6px;height:6px;border-radius:50%;background:#db2777;display:inline-block;"></span>Human Resources</span></td>
                        <td><span class="desig-text">HR Manager</span></td>
                        <td style="font-size:12.5px;color:var(--text-secondary);">03 Mar 2018</td>
                        <td style="text-align:center;">
                            <div class="action-group">
                                <button class="btn-action view" title="View Detail"
                                    data-id="2" data-name="Sari Rahayu" data-nik="1045-HRD"
                                    data-dept="Human Resources" data-desig="HR Manager"
                                    data-gender="Female" data-birth-place="Bandung" data-birth-date="1990-08-22"
                                    data-phone="082233445566" data-join="2018-03-03" data-join-end="-"
                                    data-initials="SR" data-color="linear-gradient(135deg,#db2777,#f59e0b)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit"
                                    data-id="2" data-name="Sari Rahayu" data-nik="1045-HRD"
                                    data-dept-val="HRD" data-dept-label="Human Resources"
                                    data-desig="HR Manager" data-gender="Female"
                                    data-birth-place="Bandung" data-birth-date="1990-08-22"
                                    data-phone="082233445566" data-join="2018-03-03" data-join-end="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" title="Delete"
                                    data-id="2" data-name="Sari Rahayu" data-nik="1045-HRD">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 3 --}}
                    <tr data-dept="FIN" data-gender="Male">
                        <td class="td-check"><input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;"></td>
                        <td class="td-num">3</td>
                        <td><span class="nik-mono">1012-FIN</span></td>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar" style="background:linear-gradient(135deg,#0ea66e,#0284c7);">BP</div>
                                <div>
                                    <div class="emp-full-name">Budi Prasetyo</div>
                                    <div class="emp-email">budi.p@nexahr.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="dept-badge" style="background:rgba(14,166,110,.1);color:#0ea66e;"><span style="width:6px;height:6px;border-radius:50%;background:#0ea66e;display:inline-block;"></span>Finance</span></td>
                        <td><span class="desig-text">Financial Analyst</span></td>
                        <td style="font-size:12.5px;color:var(--text-secondary);">07 Jun 2019</td>
                        <td style="text-align:center;">
                            <div class="action-group">
                                <button class="btn-action view" title="View Detail"
                                    data-id="3" data-name="Budi Prasetyo" data-nik="1012-FIN"
                                    data-dept="Finance" data-desig="Financial Analyst"
                                    data-gender="Male" data-birth-place="Surabaya" data-birth-date="1994-01-30"
                                    data-phone="085566778899" data-join="2019-06-07" data-join-end="-"
                                    data-initials="BP" data-color="linear-gradient(135deg,#0ea66e,#0284c7)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit"
                                    data-id="3" data-name="Budi Prasetyo" data-nik="1012-FIN"
                                    data-dept-val="FIN" data-dept-label="Finance"
                                    data-desig="Financial Analyst" data-gender="Male"
                                    data-birth-place="Surabaya" data-birth-date="1994-01-30"
                                    data-phone="085566778899" data-join="2019-06-07" data-join-end="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" title="Delete"
                                    data-id="3" data-name="Budi Prasetyo" data-nik="1012-FIN">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 4 --}}
                    <tr data-dept="MKT" data-gender="Female">
                        <td class="td-check"><input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;"></td>
                        <td class="td-num">4</td>
                        <td><span class="nik-mono">1088-MKT</span></td>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar" style="background:linear-gradient(135deg,#7c3aed,#db2777);">DN</div>
                                <div>
                                    <div class="emp-full-name">Dewi Nuraini</div>
                                    <div class="emp-email">dewi.n@nexahr.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="dept-badge" style="background:rgba(124,58,237,.1);color:#7c3aed;"><span style="width:6px;height:6px;border-radius:50%;background:#7c3aed;display:inline-block;"></span>Marketing</span></td>
                        <td><span class="desig-text">Digital Marketing Lead</span></td>
                        <td style="font-size:12.5px;color:var(--text-secondary);">22 Aug 2021</td>
                        <td style="text-align:center;">
                            <div class="action-group">
                                <button class="btn-action view" title="View Detail"
                                    data-id="4" data-name="Dewi Nuraini" data-nik="1088-MKT"
                                    data-dept="Marketing" data-desig="Digital Marketing Lead"
                                    data-gender="Female" data-birth-place="Yogyakarta" data-birth-date="1997-11-05"
                                    data-phone="087788990011" data-join="2021-08-22" data-join-end="-"
                                    data-initials="DN" data-color="linear-gradient(135deg,#7c3aed,#db2777)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit"
                                    data-id="4" data-name="Dewi Nuraini" data-nik="1088-MKT"
                                    data-dept-val="MKT" data-dept-label="Marketing"
                                    data-desig="Digital Marketing Lead" data-gender="Female"
                                    data-birth-place="Yogyakarta" data-birth-date="1997-11-05"
                                    data-phone="087788990011" data-join="2021-08-22" data-join-end="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" title="Delete"
                                    data-id="4" data-name="Dewi Nuraini" data-nik="1088-MKT">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 5 --}}
                    <tr data-dept="IT" data-gender="Male">
                        <td class="td-check"><input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;"></td>
                        <td class="td-num">5</td>
                        <td><span class="nik-mono">1031-ITS</span></td>
                        <td>
                            <div class="emp-cell">
                                <div class="emp-avatar" style="background:linear-gradient(135deg,#0284c7,#0ea66e);">RF</div>
                                <div>
                                    <div class="emp-full-name">Reza Firmansyah</div>
                                    <div class="emp-email">reza.f@nexahr.com</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="dept-badge" style="background:rgba(2,132,199,.1);color:#0284c7;"><span style="width:6px;height:6px;border-radius:50%;background:#0284c7;display:inline-block;"></span>IT Infrastructure</span></td>
                        <td><span class="desig-text">Network Engineer</span></td>
                        <td style="font-size:12.5px;color:var(--text-secondary);">10 Feb 2022</td>
                        <td style="text-align:center;">
                            <div class="action-group">
                                <button class="btn-action view" title="View Detail"
                                    data-id="5" data-name="Reza Firmansyah" data-nik="1031-ITS"
                                    data-dept="IT Infrastructure" data-desig="Network Engineer"
                                    data-gender="Male" data-birth-place="Semarang" data-birth-date="1995-07-18"
                                    data-phone="089900112233" data-join="2022-02-10" data-join-end="-"
                                    data-initials="RF" data-color="linear-gradient(135deg,#0284c7,#0ea66e)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-action edit" title="Edit"
                                    data-id="5" data-name="Reza Firmansyah" data-nik="1031-ITS"
                                    data-dept-val="IT" data-dept-label="IT Infrastructure"
                                    data-desig="Network Engineer" data-gender="Male"
                                    data-birth-place="Semarang" data-birth-date="1995-07-18"
                                    data-phone="089900112233" data-join="2022-02-10" data-join-end="">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-action delete" title="Delete"
                                    data-id="5" data-name="Reza Firmansyah" data-nik="1031-ITS">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="table-footer">
            <div class="table-info-text">
                Menampilkan <strong>1–5</strong> dari <strong>2,418</strong> karyawan
            </div>
            <div class="pagination-wrap">
                <button class="pg-btn"><i class="fa-solid fa-chevron-left" style="font-size:10px;"></i></button>
                <button class="pg-btn active">1</button>
                <button class="pg-btn">2</button>
                <button class="pg-btn">3</button>
                <span style="display:flex;align-items:center;padding:0 4px;font-size:12px;color:var(--text-muted);">…</span>
                <button class="pg-btn">484</button>
                <button class="pg-btn"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></button>
            </div>
        </div>

    </div>
    {{-- END TABLE CARD --}}


    {{-- ================================================================
         MODAL: ADD NEW EMPLOYEE
    ================================================================ --}}
    <div class="modal fade emp-modal" id="modalAddEmployee" tabindex="-1" aria-labelledby="labelAddEmployee" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelAddEmployee">
                        <span class="modal-title-icon blue"><i class="fa-solid fa-user-plus"></i></span>
                        Add New Employee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddEmployee" novalidate>
                        @csrf

                        <div class="form-section-title">
                            <i class="fa-solid fa-id-card"></i> Data Identitas
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-lbl">NIK <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="nik" id="add_nik"
                                       maxlength="13" placeholder="Contoh: 1001-ENG-2024" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="full_name" id="add_fullname"
                                       maxlength="50" placeholder="Nama sesuai KTP" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Departemen <span class="req">*</span></label>
                                {{-- Searchable Dropdown --}}
                                <div class="searchable-select-wrapper" id="addDeptWrapper">
                                    <div class="searchable-trigger" id="addDeptTrigger" tabindex="0">
                                        <span class="trigger-text placeholder" id="addDeptLabel">Pilih departemen…</span>
                                        <i class="fa-solid fa-chevron-down trigger-chevron"></i>
                                    </div>
                                    <div class="searchable-dropdown" id="addDeptDropdown">
                                        <div class="dd-search-wrap">
                                            <i class="fa-solid fa-magnifying-glass dd-search-icon"></i>
                                            <input type="text" class="dd-search-input" placeholder="Cari departemen…"
                                                   id="addDeptSearch" autocomplete="off">
                                        </div>
                                        <div class="dd-list" id="addDeptList">
                                            <div class="dd-item" data-val="IT" data-label="IT / Engineering">
                                                <span class="dd-dot" style="background:#4f6ef7;"></span>
                                                IT / Engineering
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                            <div class="dd-item" data-val="HRD" data-label="Human Resources">
                                                <span class="dd-dot" style="background:#db2777;"></span>
                                                Human Resources
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                            <div class="dd-item" data-val="FIN" data-label="Finance">
                                                <span class="dd-dot" style="background:#0ea66e;"></span>
                                                Finance
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                            <div class="dd-item" data-val="MKT" data-label="Marketing">
                                                <span class="dd-dot" style="background:#7c3aed;"></span>
                                                Marketing
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                            <div class="dd-item" data-val="OPS" data-label="Operations">
                                                <span class="dd-dot" style="background:#f59e0b;"></span>
                                                Operations
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                            <div class="dd-item" data-val="LEG" data-label="Legal">
                                                <span class="dd-dot" style="background:#6b7280;"></span>
                                                Legal
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                            <div class="dd-item" data-val="PRD" data-label="Product">
                                                <span class="dd-dot" style="background:#0284c7;"></span>
                                                Product
                                                <i class="fa-solid fa-check dd-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <select name="department" class="real-select" id="add_department" required>
                                        <option value="">Pilih</option>
                                        <option value="IT">IT / Engineering</option>
                                        <option value="HRD">Human Resources</option>
                                        <option value="FIN">Finance</option>
                                        <option value="MKT">Marketing</option>
                                        <option value="OPS">Operations</option>
                                        <option value="LEG">Legal</option>
                                        <option value="PRD">Product</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Jabatan / Designation <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="designation" id="add_designation"
                                       maxlength="50" placeholder="Contoh: Senior Engineer" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Gender <span class="req">*</span></label>
                                <select class="form-ctrl" name="gender" id="add_gender" required style="padding:0 14px;cursor:pointer;">
                                    <option value="">Pilih gender…</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">No. Telepon <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="phone_no" id="add_phone"
                                       maxlength="13" placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>

                        <div class="form-section-title">
                            <i class="fa-solid fa-cake-candles"></i> Data Pribadi
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-lbl">Tempat Lahir <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="birth_place" id="add_birthplace"
                                       maxlength="50" placeholder="Kota kelahiran" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Tanggal Lahir <span class="req">*</span></label>
                                <input type="date" class="form-ctrl" name="birth_date" id="add_birthdate" required>
                            </div>
                        </div>

                        <div class="form-section-title">
                            <i class="fa-solid fa-briefcase"></i> Data Kepegawaian
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-lbl">Tanggal Bergabung <span class="req">*</span></label>
                                <input type="date" class="form-ctrl" name="join_date" id="add_joindate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Tanggal Berakhir Kontrak</label>
                                <input type="date" class="form-ctrl" name="join_end_date" id="add_joinenddate">
                                <small style="font-size:11px;color:var(--text-muted);margin-top:4px;display:block;">
                                    <i class="fa-solid fa-circle-info"></i> Kosongkan jika karyawan tetap.
                                </small>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark me-1"></i> Batal
                    </button>
                    <button type="button" class="btn-modal-submit blue" id="btnSaveEmployee">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Karyawan
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================================
         MODAL: VIEW EMPLOYEE
    ================================================================ --}}
    <div class="modal fade emp-modal" id="modalViewEmployee" tabindex="-1" aria-labelledby="labelViewEmployee" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelViewEmployee">
                        <span class="modal-title-icon blue"><i class="fa-solid fa-id-badge"></i></span>
                        Detail Karyawan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Hero --}}
                    <div class="view-hero">
                        <div class="view-hero-avatar" id="viewAvatar">AW</div>
                        <div>
                            <div class="view-hero-name" id="viewName">—</div>
                            <div class="view-hero-desig">
                                <span id="viewDesig">—</span>
                                <span style="opacity:.4;">|</span>
                                <span id="viewDept">—</span>
                            </div>
                        </div>
                    </div>
                    {{-- Detail grid --}}
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-key"><i class="fa-solid fa-id-card me-1"></i>NIK</div>
                            <div class="detail-val mono" id="viewNik">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-key"><i class="fa-solid fa-venus-mars me-1"></i>Gender</div>
                            <div class="detail-val" id="viewGender">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-key"><i class="fa-solid fa-map-pin me-1"></i>Tempat Lahir</div>
                            <div class="detail-val" id="viewBirthPlace">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-key"><i class="fa-solid fa-cake-candles me-1"></i>Tanggal Lahir</div>
                            <div class="detail-val" id="viewBirthDate">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-key"><i class="fa-solid fa-phone me-1"></i>No. Telepon</div>
                            <div class="detail-val mono" id="viewPhone">—</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-key"><i class="fa-solid fa-calendar-plus me-1"></i>Tgl. Bergabung</div>
                            <div class="detail-val" id="viewJoin">—</div>
                        </div>
                        <div class="detail-item" style="grid-column:1/-1;">
                            <div class="detail-key"><i class="fa-solid fa-calendar-xmark me-1"></i>Tgl. Akhir Kontrak</div>
                            <div class="detail-val" id="viewJoinEnd">—</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn-modal-submit blue" id="btnViewToEdit">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Data Ini
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- ================================================================
         MODAL: EDIT EMPLOYEE
    ================================================================ --}}
    <div class="modal fade emp-modal" id="modalEditEmployee" tabindex="-1" aria-labelledby="labelEditEmployee" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="labelEditEmployee">
                        <span class="modal-title-icon amber"><i class="fa-solid fa-pen-to-square"></i></span>
                        Edit Data Karyawan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditEmployee" novalidate>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="employee_id" id="edit_id">

                        <div class="form-section-title"><i class="fa-solid fa-id-card"></i> Data Identitas</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-lbl">NIK <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="nik" id="edit_nik" maxlength="13" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="full_name" id="edit_fullname" maxlength="50" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Departemen <span class="req">*</span></label>
                                <div class="searchable-select-wrapper" id="editDeptWrapper">
                                    <div class="searchable-trigger" id="editDeptTrigger" tabindex="0">
                                        <span class="trigger-text placeholder" id="editDeptLabel">Pilih departemen…</span>
                                        <i class="fa-solid fa-chevron-down trigger-chevron"></i>
                                    </div>
                                    <div class="searchable-dropdown" id="editDeptDropdown">
                                        <div class="dd-search-wrap">
                                            <i class="fa-solid fa-magnifying-glass dd-search-icon"></i>
                                            <input type="text" class="dd-search-input" placeholder="Cari departemen…" id="editDeptSearch" autocomplete="off">
                                        </div>
                                        <div class="dd-list" id="editDeptList">
                                            <div class="dd-item" data-val="IT"  data-label="IT / Engineering"><span class="dd-dot" style="background:#4f6ef7;"></span>IT / Engineering<i class="fa-solid fa-check dd-check"></i></div>
                                            <div class="dd-item" data-val="HRD" data-label="Human Resources"><span class="dd-dot" style="background:#db2777;"></span>Human Resources<i class="fa-solid fa-check dd-check"></i></div>
                                            <div class="dd-item" data-val="FIN" data-label="Finance"><span class="dd-dot" style="background:#0ea66e;"></span>Finance<i class="fa-solid fa-check dd-check"></i></div>
                                            <div class="dd-item" data-val="MKT" data-label="Marketing"><span class="dd-dot" style="background:#7c3aed;"></span>Marketing<i class="fa-solid fa-check dd-check"></i></div>
                                            <div class="dd-item" data-val="OPS" data-label="Operations"><span class="dd-dot" style="background:#f59e0b;"></span>Operations<i class="fa-solid fa-check dd-check"></i></div>
                                            <div class="dd-item" data-val="LEG" data-label="Legal"><span class="dd-dot" style="background:#6b7280;"></span>Legal<i class="fa-solid fa-check dd-check"></i></div>
                                            <div class="dd-item" data-val="PRD" data-label="Product"><span class="dd-dot" style="background:#0284c7;"></span>Product<i class="fa-solid fa-check dd-check"></i></div>
                                        </div>
                                    </div>
                                    <select name="department" class="real-select" id="edit_department" required>
                                        <option value="">Pilih</option>
                                        <option value="IT">IT / Engineering</option>
                                        <option value="HRD">Human Resources</option>
                                        <option value="FIN">Finance</option>
                                        <option value="MKT">Marketing</option>
                                        <option value="OPS">Operations</option>
                                        <option value="LEG">Legal</option>
                                        <option value="PRD">Product</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Jabatan / Designation <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="designation" id="edit_designation" maxlength="50" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Gender <span class="req">*</span></label>
                                <select class="form-ctrl" name="gender" id="edit_gender" required style="padding:0 14px;cursor:pointer;">
                                    <option value="">Pilih gender…</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">No. Telepon <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="phone_no" id="edit_phone" maxlength="13" required>
                            </div>
                        </div>

                        <div class="form-section-title"><i class="fa-solid fa-cake-candles"></i> Data Pribadi</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-lbl">Tempat Lahir <span class="req">*</span></label>
                                <input type="text" class="form-ctrl" name="birth_place" id="edit_birthplace" maxlength="50" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Tanggal Lahir <span class="req">*</span></label>
                                <input type="date" class="form-ctrl" name="birth_date" id="edit_birthdate" required>
                            </div>
                        </div>

                        <div class="form-section-title"><i class="fa-solid fa-briefcase"></i> Data Kepegawaian</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-lbl">Tanggal Bergabung <span class="req">*</span></label>
                                <input type="date" class="form-ctrl" name="join_date" id="edit_joindate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-lbl">Tanggal Berakhir Kontrak</label>
                                <input type="date" class="form-ctrl" name="join_end_date" id="edit_joinenddate">
                                <small style="font-size:11px;color:var(--text-muted);margin-top:4px;display:block;">
                                    <i class="fa-solid fa-circle-info"></i> Kosongkan jika karyawan tetap.
                                </small>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark me-1"></i> Batal
                    </button>
                    <button type="button" class="btn-modal-submit amber" id="btnUpdateEmployee">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection


{{-- ================================================================
     SCRIPTS
================================================================ --}}
@section('scripts')
<script>
$(function () {

    /* ==============================================================
       HELPER — Format date "2024-01-15" → "15 Jan 2024"
    ============================================================== */
    var MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    function fmtDate(val) {
        if (!val || val === '-') return '—';
        var p = val.split('-');
        if (p.length < 3) return val;
        return parseInt(p[2]) + ' ' + MONTHS[parseInt(p[1]) - 1] + ' ' + p[0];
    }

    function escHtml(s) {
        return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }


    /* ==============================================================
       SEARCHABLE DROPDOWN — factory function
       Reusable for both Add & Edit modal dept selectors
    ============================================================== */
    function initSearchableDropdown(opts) {
        /*
         * opts = {
         *   triggerId      : '#addDeptTrigger',
         *   dropdownId     : '#addDeptDropdown',
         *   searchId       : '#addDeptSearch',
         *   listId         : '#addDeptList',
         *   labelId        : '#addDeptLabel',
         *   realSelectId   : '#add_department',
         *   wrapperId      : '#addDeptWrapper'
         * }
         */
        var $trigger    = $(opts.triggerId);
        var $dropdown   = $(opts.dropdownId);
        var $search     = $(opts.searchId);
        var $list       = $(opts.listId);
        var $label      = $(opts.labelId);
        var $real       = $(opts.realSelectId);
        var selectedVal = '';

        // Toggle open/close
        $trigger.on('click keydown', function (e) {
            if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
            e.preventDefault();
            toggleDropdown();
        });

        function toggleDropdown() {
            var isOpen = $dropdown.hasClass('open');
            closeAllDropdowns();
            if (!isOpen) {
                $dropdown.addClass('open');
                $trigger.addClass('open');
                $search.val('').trigger('input').focus();
            }
        }

        // Close when clicking outside
        $(document).on('click', function (e) {
            if (!$(opts.wrapperId).is(e.target) && $(opts.wrapperId).has(e.target).length === 0) {
                $dropdown.removeClass('open');
                $trigger.removeClass('open');
            }
        });

        // Search / filter list items
        $search.on('input', function () {
            var q = $(this).val().toLowerCase().trim();
            var any = false;
            $list.find('.dd-item').each(function () {
                var match = $(this).text().toLowerCase().includes(q);
                $(this).toggle(match);
                if (match) any = true;
            });
            $list.find('.dd-empty').remove();
            if (!any) $list.append('<div class="dd-empty">Tidak ditemukan.</div>');
        });

        // Select item
        $list.on('click', '.dd-item', function () {
            var val   = $(this).data('val');
            var lbl   = $(this).data('label');
            selectedVal = val;

            // Update visuals
            $list.find('.dd-item').removeClass('selected');
            $(this).addClass('selected');

            // Update trigger label
            $label.text(lbl).removeClass('placeholder');

            // Update real hidden select
            $real.val(val);

            // Close dropdown
            $dropdown.removeClass('open');
            $trigger.removeClass('open');
        });

        // Public: pre-select a value (for edit modal)
        return {
            setValue: function (val, lbl) {
                selectedVal = val;
                $list.find('.dd-item').removeClass('selected');
                $list.find('.dd-item[data-val="' + val + '"]').addClass('selected');
                if (lbl) {
                    $label.text(lbl).removeClass('placeholder');
                } else {
                    var autoLbl = $list.find('.dd-item[data-val="' + val + '"]').data('label') || val;
                    $label.text(autoLbl).removeClass('placeholder');
                }
                $real.val(val);
            },
            reset: function () {
                selectedVal = '';
                $list.find('.dd-item').removeClass('selected');
                $label.text('Pilih departemen…').addClass('placeholder');
                $real.val('');
            },
            getVal: function () { return selectedVal; }
        };
    }

    function closeAllDropdowns() {
        $('.searchable-dropdown').removeClass('open');
        $('.searchable-trigger').removeClass('open');
    }

    // Initialise both dropdowns
    var addDeptDD  = initSearchableDropdown({
        triggerId:   '#addDeptTrigger',
        dropdownId:  '#addDeptDropdown',
        searchId:    '#addDeptSearch',
        listId:      '#addDeptList',
        labelId:     '#addDeptLabel',
        realSelectId:'#add_department',
        wrapperId:   '#addDeptWrapper'
    });

    var editDeptDD = initSearchableDropdown({
        triggerId:   '#editDeptTrigger',
        dropdownId:  '#editDeptDropdown',
        searchId:    '#editDeptSearch',
        listId:      '#editDeptList',
        labelId:     '#editDeptLabel',
        realSelectId:'#edit_department',
        wrapperId:   '#editDeptWrapper'
    });


    /* ==============================================================
       FILTER TABLE (client-side simulation)
    ============================================================== */
    $('#checkAll').on('change', function () {
        $('.row-check:visible').prop('checked', $(this).is(':checked'));
    });

    function applyFilter() {
        var dept    = $('#filterDept').val();
        var gender  = $('#filterGender').val();
        var keyword = $('#searchEmployee').val().trim().toLowerCase();

        $('#employeeTbody tr').each(function () {
            var rowDept   = $(this).data('dept')   || '';
            var rowGender = $(this).data('gender') || '';
            var rowText   = $(this).text().toLowerCase();

            var matchDept   = !dept   || rowDept === dept;
            var matchGender = !gender || rowGender === gender;
            var matchKw     = !keyword || rowText.includes(keyword);

            $(this).toggle(matchDept && matchGender && matchKw);
        });
    }

    $('#btnApplyFilter').on('click', applyFilter);
    $('#searchEmployee').on('keyup', applyFilter);

    $('#btnResetFilter').on('click', function () {
        $('#filterDept').val('');
        $('#filterGender').val('');
        $('#searchEmployee').val('');
        $('#employeeTbody tr').show();
    });

    // Reset add modal on close
    $('#modalAddEmployee').on('hidden.bs.modal', function () {
        $('#formAddEmployee')[0].reset();
        addDeptDD.reset();
        $('.form-ctrl').removeClass('is-invalid');
    });


    /* ==============================================================
       VIEW MODAL — populate from data-* attributes
    ============================================================== */
    var _currentViewData = {};

    $(document).on('click', '.btn-action.view', function () {
        var d = $(this).data();
        _currentViewData = d;

        $('#viewName').text(d.name || '—');
        $('#viewDesig').text(d.desig || '—');
        $('#viewDept').text(d.dept || '—');
        $('#viewNik').text(d.nik || '—');
        $('#viewGender').text(d.gender || '—');
        $('#viewBirthPlace').text(d.birthPlace || d['birth-place'] || '—');
        $('#viewBirthDate').text(fmtDate(d.birthDate || d['birth-date'] || ''));
        $('#viewPhone').text(d.phone || '—');
        $('#viewJoin').text(fmtDate(d.join || ''));
        $('#viewJoinEnd').text(d.joinEnd === '-' || !d.joinEnd ? 'Karyawan Tetap (tidak terbatas)' : fmtDate(d.joinEnd));

        // Avatar
        $('#viewAvatar')
            .text(d.initials || (d.name || '??').substring(0,2).toUpperCase())
            .css('background', d.color || 'linear-gradient(135deg,#4f6ef7,#7c3aed)');

        var modal = new bootstrap.Modal(document.getElementById('modalViewEmployee'));
        modal.show();
    });

    // "Edit Data Ini" from view modal
    $('#btnViewToEdit').on('click', function () {
        bootstrap.Modal.getInstance(document.getElementById('modalViewEmployee')).hide();
        setTimeout(function () {
            // Trigger the edit button for the same record by constructing a proxy
            var d = _currentViewData;
            populateEditModal({
                id: d.id, name: d.name, nik: d.nik,
                deptVal: d.deptVal || d['dept-val'] || '',
                deptLabel: d.dept,
                desig: d.desig, gender: d.gender,
                birthPlace: d.birthPlace || d['birth-place'] || '',
                birthDate: d.birthDate || d['birth-date'] || '',
                phone: d.phone, join: d.join, joinEnd: d.joinEnd === '-' ? '' : (d.joinEnd || '')
            });
            var editModal = new bootstrap.Modal(document.getElementById('modalEditEmployee'));
            editModal.show();
        }, 350);
    });


    /* ==============================================================
       EDIT MODAL — populate from data-* attributes
    ============================================================== */
    function populateEditModal(d) {
        $('#edit_id').val(d.id || '');
        $('#edit_nik').val(d.nik || '');
        $('#edit_fullname').val(d.name || '');
        $('#edit_designation').val(d.desig || '');
        $('#edit_gender').val(d.gender || '');
        $('#edit_birthplace').val(d.birthPlace || '');
        $('#edit_birthdate').val(d.birthDate || '');
        $('#edit_phone').val(d.phone || '');
        $('#edit_joindate').val(d.join || '');
        $('#edit_joinenddate').val(d.joinEnd || '');
        editDeptDD.setValue(d.deptVal || '', d.deptLabel || '');
    }

    $(document).on('click', '.btn-action.edit', function () {
        var d = $(this).data();
        populateEditModal({
            id: d.id, name: d.name, nik: d.nik,
            deptVal: d.deptVal || d['dept-val'] || '',
            deptLabel: d.deptLabel || d['dept-label'] || '',
            desig: d.desig, gender: d.gender,
            birthPlace: d.birthPlace || d['birth-place'] || '',
            birthDate: d.birthDate || d['birth-date'] || '',
            phone: d.phone, join: d.join,
            joinEnd: d.joinEnd || d['join-end'] || ''
        });
        var modal = new bootstrap.Modal(document.getElementById('modalEditEmployee'));
        modal.show();
    });

    // Reset edit modal on close
    $('#modalEditEmployee').on('hidden.bs.modal', function () {
        $('#formEditEmployee')[0].reset();
        editDeptDD.reset();
        $('.form-ctrl').removeClass('is-invalid');
    });


    /* ==============================================================
       FORM VALIDATION — generic
    ============================================================== */
    function validateForm($form) {
        var valid = true;
        $form.find('[required]').each(function () {
            $(this).removeClass('is-invalid');
            if (!$.trim($(this).val())) {
                $(this).addClass('is-invalid');
                valid = false;
            }
        });
        return valid;
    }


    /* ==============================================================
       SAVE NEW EMPLOYEE
    ============================================================== */
    $('#btnSaveEmployee').on('click', function () {
        var $form = $('#formAddEmployee');
        if (!validateForm($form)) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Belum Lengkap',
                text: 'Harap isi semua field yang wajib diisi (ditandai *).',
                confirmButtonColor: '#4f6ef7'
            });
            return;
        }

        Swal.fire({
            title: 'Menyimpan Data…',
            text: 'Karyawan baru sedang ditambahkan ke database.',
            allowOutsideClick: false,
            didOpen: function () { Swal.showLoading(); }
        });
        @php
        /*
         * Ganti simulasi ini dengan AJAX ke route Anda:
         * $.ajax({
         *   url: '{{ route("employees.store") }}',
         *   method: 'POST',
         *   data: $form.serialize(),
         *   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         *   success: function(r) { ... },
         *   error: function(e) { ... }
         * });
         */ 
        @endphp
        setTimeout(function () {
            bootstrap.Modal.getInstance(document.getElementById('modalAddEmployee')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Karyawan Berhasil Ditambahkan!',
                html: 'Data karyawan <strong>' + escHtml($('#add_fullname').val()) + '</strong> telah disimpan.',
                confirmButtonColor: '#4f6ef7',
                confirmButtonText: 'Oke'
            });
        }, 1800);
    });


    /* ==============================================================
       UPDATE EMPLOYEE
    ============================================================== */
    $('#btnUpdateEmployee').on('click', function () {
        var $form = $('#formEditEmployee');
        if (!validateForm($form)) {
            Swal.fire({
                icon: 'warning',
                title: 'Form Belum Lengkap',
                text: 'Harap isi semua field yang wajib diisi (ditandai *).',
                confirmButtonColor: '#4f6ef7'
            });
            return;
        }

        Swal.fire({
            title: 'Menyimpan Perubahan…',
            allowOutsideClick: false,
            didOpen: function () { Swal.showLoading(); }
        });

        /*
         * AJAX PUT/PATCH ke route Anda:
         * $.ajax({
         *   url: '/employees/' + $('#edit_id').val(),
         *   method: 'POST', // Laravel: _method=PUT via @method('PUT')
         *   data: $form.serialize(),
         *   headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         *   success: function(r) { ... }
         * });
         */
        setTimeout(function () {
            bootstrap.Modal.getInstance(document.getElementById('modalEditEmployee')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Data Berhasil Diperbarui!',
                html: 'Perubahan data <strong>' + escHtml($('#edit_fullname').val()) + '</strong> telah disimpan.',
                confirmButtonColor: '#4f6ef7'
            });
        }, 1600);
    });


    /* ==============================================================
       DELETE CONFIRMATION — SweetAlert2
    ============================================================== */
    $(document).on('click', '.btn-action.delete', function () {
        var id   = $(this).data('id');
        var name = $(this).data('name');
        var nik  = $(this).data('nik');
        var $row = $(this).closest('tr');

        Swal.fire({
            icon: 'warning',
            title: 'Hapus Karyawan?',
            html:
                '<div style="text-align:left;padding:8px 0;">' +
                '<p style="margin-bottom:10px;">Anda akan menghapus data berikut secara permanen:</p>' +
                '<div style="background:var(--bg-body);border:1px solid var(--border-color);border-radius:10px;padding:12px 16px;font-size:13.5px;">' +
                '<div style="margin-bottom:6px;"><strong style="color:var(--text-primary);">' + escHtml(name) + '</strong></div>' +
                '<div style="font-size:12px;color:var(--text-muted);font-family:monospace;">' + escHtml(nik) + '</div>' +
                '</div>' +
                '<p style="margin-top:12px;font-size:12.5px;color:#f05252;"><i class="fa-solid fa-triangle-exclamation me-1"></i>Tindakan ini <strong>tidak dapat dibatalkan</strong>.</p>' +
                '</div>',
            showCancelButton: true,
            confirmButtonColor: '#f05252',
            cancelButtonColor:  '#6b7280',
            confirmButtonText:  '<i class="fa-solid fa-trash-can me-1"></i> Ya, Hapus',
            cancelButtonText:   'Batal',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                confirmButton: 'swal-btn-danger',
                popup: 'swal2-popup'
            }
        }).then(function (result) {
            if (!result.isConfirmed) return;

            // Loading state
            Swal.fire({
                title: 'Menghapus Data…',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function () { Swal.showLoading(); }
            });

            /*
             * AJAX DELETE ke route Anda:
             * $.ajax({
             *   url: '/employees/' + id,
             *   method: 'POST',
             *   data: { _method: 'DELETE', _token: $('meta[name="csrf-token"]').attr('content') },
             *   success: function() {
             *     $row.fadeOut(300, function(){ $(this).remove(); });
             *     Swal.fire({ icon:'success', title:'Dihapus!', ... });
             *   }
             * });
             */
            setTimeout(function () {
                // Animasi hapus baris dari tabel
                $row.css({ transition: 'opacity .3s, transform .3s', opacity: '0', transform: 'translateX(20px)' });
                setTimeout(function () { $row.remove(); }, 320);

                Swal.fire({
                    icon: 'success',
                    title: 'Data Berhasil Dihapus',
                    html: 'Karyawan <strong>' + escHtml(name) + '</strong> telah dihapus dari sistem.',
                    confirmButtonColor: '#4f6ef7',
                    timer: 3000,
                    timerProgressBar: true
                });
            }, 1400);
        });
    });


    /* ==============================================================
       FLASH MESSAGES from Laravel session
    ============================================================== */
    @if(session('success'))
        Swal.fire({
            toast: true, position: 'top-end',
            icon: 'success',
            title: "{{ addslashes(session('success')) }}",
            showConfirmButton: false,
            timer: 3000, timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: "{{ addslashes(session('error')) }}",
            confirmButtonColor: '#4f6ef7'
        });
    @endif

});
</script>
@endsection