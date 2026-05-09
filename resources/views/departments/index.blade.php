@extends('layouts.app')

@section('title', 'Department Management')
@section('page_title', 'Department Management')

{{-- ================================================================
     PAGE CSS
================================================================ --}}
@section('css')
    <link href="{{ asset('css/department.css') }}" rel="stylesheet">
@endsection


{{-- ================================================================
     CONTENT
================================================================ --}}
@section('content')

    {{-- ============ PAGE HEADER ============ --}}
    <div class="dept-page-header">
        <div>
            <div class="dept-eyebrow">
                <span class="pulse-dot"></span>
                Master Data
            </div>
            <h1 class="dept-heading">Department Management</h1>
            <p class="dept-subheading">Kelola struktur divisi dan departemen perusahaan.</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <button class="btn-secondary-dept">
                <i class="fa-solid fa-file-arrow-down"></i> Export
            </button>
            <button class="btn-primary-dept"
                    data-bs-toggle="modal" data-bs-target="#modalAddDepartment">
                <i class="fa-solid fa-plus"></i> Add New Department
            </button>
        </div>
    </div>

    {{-- ============ STATS MINI ROW ============ --}}
    <div class="stats-row">
        <div class="stat-chip-mini">
            <span class="chip-dot" style="background:#4f6ef7;"></span>
            Total Departments: <strong>18</strong>
        </div>
        <div class="stat-chip-mini">
            <span class="chip-dot" style="background:#0ea66e;"></span>
            Active: <strong>16</strong>
        </div>
        <div class="stat-chip-mini">
            <span class="chip-dot" style="background:#f59e0b;"></span>
            No Members: <strong>2</strong>
        </div>
    </div>

    {{-- ============ FILTER & SEARCH ============ --}}
    <div class="filter-card">
        <div class="filter-row">

            <div class="filter-field search-field" style="flex:1;">
                <span class="filter-label"><i class="fa-solid fa-magnifying-glass me-1"></i> Search Department</span>
                <div style="position:relative;">
                    <i class="fa-solid fa-magnifying-glass s-icon"
                       style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px;pointer-events:none;"></i>
                    <input type="text" class="dept-form-input" id="searchDept"
                           placeholder="Search department name…"
                           style="padding-left:38px;width:100%;"
                           value="{{ request('search') }}">
                </div>
            </div>

            <div class="filter-actions" style="align-self:flex-end;">
                <button class="btn-primary-dept" id="btnApplyFilter" style="padding:9px 18px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                <button class="btn-secondary-dept" id="btnResetFilter">
                    <i class="fa-solid fa-xmark"></i> Reset
                </button>
            </div>

        </div>
    </div>

    {{-- ============ TABLE CARD ============ --}}
    <div class="table-card">

        <div class="table-card-header">
            <div class="table-card-title">
                <i class="fa-solid fa-building" style="color:var(--accent-text);font-size:16px;"></i>
                Daftar Departemen
                <span class="title-pill" id="rowCountPill">18 records</span>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button class="btn-secondary-dept" style="padding:7px 14px;font-size:12px;">
                    <i class="fa-solid fa-rotate-right"></i> Refresh
                </button>
            </div>
        </div>

        <div class="table-wrap">
            <table class="dept-table" id="deptTable">
                <thead>
                    <tr>
                        <th style="width:44px;padding-left:20px;">
                            <input type="checkbox" id="checkAll"
                                   style="accent-color:var(--accent);width:15px;height:15px;">
                        </th>
                        <th>#</th>
                        <th>Department Name</th>
                        <th>Employees</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="deptTbody">

                    @php
                        $deptColors = [
                            '#4f6ef7','#0ea66e','#f59e0b','#0284c7',
                            '#7c3aed','#db2777','#64748b','#ef4444',
                            '#8b5cf6','#06b6d4',
                        ];

                        $departments = [
                            ['id'=>1,  'name'=>'Information Technology',  'emp_count'=>42],
                            ['id'=>2,  'name'=>'Finance & Accounting',     'emp_count'=>27],
                            ['id'=>3,  'name'=>'Human Resources',          'emp_count'=>15],
                            ['id'=>4,  'name'=>'Engineering',              'emp_count'=>88],
                            ['id'=>5,  'name'=>'Marketing',                'emp_count'=>34],
                            ['id'=>6,  'name'=>'Operations',               'emp_count'=>61],
                            ['id'=>7,  'name'=>'Legal',                    'emp_count'=>9],
                            ['id'=>8,  'name'=>'Sales',                    'emp_count'=>53],
                            ['id'=>9,  'name'=>'Product',                  'emp_count'=>22],
                            ['id'=>10, 'name'=>'Research & Development',   'emp_count'=>18],
                        ];
                    @endphp

                    @foreach($departments as $i => $dept)
                    @php $color = $deptColors[$i % count($deptColors)]; @endphp
                    <tr data-id="{{ $dept['id'] }}" data-name="{{ $dept['name'] }}">
                        <td style="padding-left:20px;">
                            <input type="checkbox" class="row-check"
                                   style="accent-color:var(--accent);width:15px;height:15px;">
                        </td>
                        <td>
                            <span class="dept-index-badge">{{ str_pad($dept['id'], 2, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="dept-cell">
                                <div class="dept-icon-box"
                                     style="background:{{ $color }}1a; color:{{ $color }};">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <div>
                                    <div class="dept-name-text">{{ $dept['name'] }}</div>
                                    <div class="dept-meta-text">dept.{{ strtolower(str_replace([' ', '&', '/'], ['-', 'n', ''], $dept['name'])) }}@nexahr.id</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="emp-count-chip">
                                <i class="fa-solid fa-users" style="font-size:10px;"></i>
                                {{ $dept['emp_count'] }} employees
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div class="action-group" style="justify-content:center;">
                                <a href="{{ url('/employees?dept_id=' . $dept['id']) }}"
                                   class="btn-act btn-act-view"
                                   title="Lihat Karyawan">
                                    <i class="fa-solid fa-users"></i>
                                </a>
                                <button class="btn-act btn-act-edit"
                                        title="Edit Department"
                                        data-action="edit"
                                        data-id="{{ $dept['id'] }}"
                                        data-name="{{ $dept['name'] }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-act btn-act-del"
                                        title="Delete Department"
                                        data-action="delete"
                                        data-id="{{ $dept['id'] }}"
                                        data-name="{{ $dept['name'] }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
        <div class="table-footer">
            <div class="table-info">
                Menampilkan <strong id="showFrom">1</strong>–<strong id="showTo">10</strong>
                dari <strong id="showTotal">10</strong> departemen
            </div>
            <div class="pagination-wrap">
                <button class="pg-btn"><i class="fa-solid fa-chevron-left" style="font-size:10px;"></i></button>
                <button class="pg-btn active">1</button>
                <button class="pg-btn">2</button>
                <span style="display:flex;align-items:center;padding:0 4px;color:var(--text-muted);font-size:12px;">…</span>
                <button class="pg-btn">18</button>
                <button class="pg-btn"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></button>
            </div>
        </div>

    </div>
    {{-- END TABLE CARD --}}


    {{-- ================================================================
         MODAL: ADD NEW DEPARTMENT
    ================================================================ --}}
    <div class="modal fade dept-modal" id="modalAddDepartment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('/departments') }}" method="POST" id="formAddDept" novalidate>
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="modal-title-icon"><i class="fa-solid fa-folder-plus"></i></span>
                            Add New Department
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="f-label">
                                Department Name <span class="req">*</span>
                            </label>
                            <input type="text" name="Dept_name" id="addDeptName"
                                   class="f-input"
                                   maxlength="50"
                                   placeholder="Contoh: Production Dept"
                                   required autofocus>
                        </div>
                    </div>

                    <div class="modal-footer" style="justify-content:space-between;">
                        <span class="modal-hint">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Kolom bertanda <span style="color:#f05252;font-weight:700;">*</span> wajib diisi.
                        </span>
                        <div style="display:flex;gap:10px;">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i> Batal
                            </button>
                            <button type="submit" class="btn-modal-save">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- END MODAL ADD --}}


    {{-- ================================================================
         MODAL: EDIT DEPARTMENT
    ================================================================ --}}
    <div class="modal fade dept-modal" id="modalEditDepartment" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="#" method="POST" id="formEditDept" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editDeptId" name="id">

                    <div class="modal-header"
                         style="background:linear-gradient(135deg,rgba(245,158,11,.1),var(--bg-card));">
                        <h5 class="modal-title">
                            <span class="modal-title-icon"
                                  style="background:linear-gradient(135deg,#f59e0b,#ef4444);">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </span>
                            Edit Department
                            <span style="font-size:12px;font-weight:500;color:var(--text-muted);margin-left:4px;"
                                  id="editModalLabel"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="f-label">
                                Department Name <span class="req">*</span>
                            </label>
                            <input type="text" name="Dept_name" id="editDeptName"
                                   class="f-input"
                                   maxlength="50"
                                   required>
                        </div>
                    </div>

                    <div class="modal-footer" style="justify-content:space-between;">
                        <span class="modal-hint">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Kolom bertanda <span style="color:#f05252;font-weight:700;">*</span> wajib diisi.
                        </span>
                        <div style="display:flex;gap:10px;">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i> Batal
                            </button>
                            <button type="submit" class="btn-modal-save-warn">
                                <i class="fa-solid fa-floppy-disk"></i> Update
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- END MODAL EDIT --}}

@endsection


{{-- ================================================================
     SCRIPTS
================================================================ --}}
@section('scripts')
<script>
$(function () {

    /* ================================================================
       FILTER / SEARCH (client-side on dummy data)
    ================================================================ */
    function applyFilters() {
        var keyword = $('#searchDept').val().trim().toLowerCase();
        var visible = 0;

        $('#deptTbody tr').each(function () {
            var name = $(this).find('.dept-name-text').text().toLowerCase();
            var show = !keyword || name.includes(keyword);
            $(this).toggle(show);
            if (show) visible++;
        });

        $('#showFrom').text(visible ? 1 : 0);
        $('#showTo').text(visible);
        $('#showTotal').text(visible);
        $('#rowCountPill').text(visible + ' records');
    }

    $('#btnApplyFilter').on('click', applyFilters);
    $('#searchDept').on('keyup', applyFilters);

    $('#btnResetFilter').on('click', function () {
        $('#searchDept').val('');
        $('#deptTbody tr').show();
        $('#showFrom').text(1);
        $('#showTo').text(10);
        $('#showTotal').text(10);
        $('#rowCountPill').text('18 records');
    });

    // Check-all
    $('#checkAll').on('change', function () {
        $('.row-check').prop('checked', $(this).is(':checked'));
    });


    /* ================================================================
       EDIT MODAL — populate from data-* on button
    ================================================================ */
    $(document).on('click', '[data-action="edit"]', function () {
        var $btn = $(this);
        var id   = $btn.data('id');
        var name = $btn.data('name');

        $('#editDeptId').val(id);
        $('#editDeptName').val(name);
        $('#editModalLabel').text('— ' + name);

        // Update form action
        $('#formEditDept').attr('action', '{{ url("/departments") }}/' + id);

        var editModal = new bootstrap.Modal(document.getElementById('modalEditDepartment'));
        editModal.show();
    });

    // Reset add modal on close
    document.getElementById('modalAddDepartment').addEventListener('hidden.bs.modal', function () {
        $('#addDeptName').val('').removeClass('is-invalid');
    });


    /* ================================================================
       DELETE — SweetAlert2 konfirmasi
    ================================================================ */
    $(document).on('click', '[data-action="delete"]', function () {
        var $btn = $(this);
        var name = $btn.data('name');
        var id   = $btn.data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Hapus Departemen?',
            html:
                'Anda akan menghapus departemen:<br>' +
                '<strong style="font-size:15px;">' + name + '</strong>' +
                '<br><br>' +
                '<span style="font-size:13px;color:#e53e3e;">Pastikan tidak ada karyawan di departemen ini.<br>Tindakan ini <u>tidak dapat dibatalkan</u>.</span>',
            showCancelButton: true,
            confirmButtonColor: '#f05252',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> Ya, Hapus',
            cancelButtonText: '<i class="fa-solid fa-xmark me-1"></i> Batal',
            reverseButtons: true,
            focusCancel: true,
        }).then(function (result) {
            if (!result.isConfirmed) return;

            Swal.fire({
                title: 'Menghapus Data…',
                html: 'Sedang memproses penghapusan <strong>' + name + '</strong>.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function () { Swal.showLoading(); }
            });

            /*
             * AJAX DELETE ke: {{ url('/departments') }}/<id>
             *
             * $.ajax({
             *     url: '{{ url("/departments") }}/' + id,
             *     method: 'DELETE',
             *     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
             *     success: function() { ... },
             *     error: function() { ... }
             * });
             */
            setTimeout(function () {
                var $row = $('[data-action="delete"][data-id="' + id + '"]').closest('tr');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Dihapus',
                    html: 'Departemen <strong>' + name + '</strong> telah dihapus dari sistem.',
                    confirmButtonColor: '#4f6ef7',
                    timer: 2800,
                    timerProgressBar: true,
                    showConfirmButton: false
                });

                $row.css({ transition: 'opacity .35s ease, transform .35s ease', opacity: 0, transform: 'translateX(20px)' });
                setTimeout(function () { $row.remove(); }, 380);
            }, 1500);
        });
    });


    /* ================================================================
       FLASH MESSAGE dari session
    ================================================================ */
    @if(session('swal'))
        Swal.fire(@json(session('swal')));
    @endif

});
</script>
@endsection