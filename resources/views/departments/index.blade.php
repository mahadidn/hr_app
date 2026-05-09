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
        <form class="filter-row" action="{{ url('/departments') }}" method="GET">
            <div class="filter-field search-field" style="flex:1;">
                <span class="filter-label"><i class="fa-solid fa-magnifying-glass me-1"></i> Search Department</span>
                <div style="position:relative;">
                    <i class="fa-solid fa-magnifying-glass s-icon" style="..."></i>
                    <!-- Tambahkan attribute name="search" -->
                    <input type="text" name="search" class="dept-form-input" id="searchDept" placeholder="Search department name…" style="padding-left:38px;width:100%;" value="{{ request('search') }}">
                </div>
            </div>
            <div class="filter-actions" style="align-self:flex-end;">
                <button type="submit" class="btn-primary-dept" style="padding:9px 18px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                <a href="{{ url('/departments') }}" class="btn-secondary-dept" style="text-decoration:none;">
                    <i class="fa-solid fa-xmark"></i> Reset
                </a>
            </div>
        </form>
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
                        <th>#</th>
                        <th>Department Name</th>
                        <th>Employees</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="deptTbody">
                    @php
                        $deptColors = ['#4f6ef7','#0ea66e','#f59e0b','#0284c7','#7c3aed','#db2777','#64748b','#ef4444','#8b5cf6','#06b6d4'];
                    @endphp

                    @forelse($departments as $i => $dept)
                        @php $color = $deptColors[$i % count($deptColors)]; @endphp
                        <tr data-id="{{ $dept->id }}" data-name="{{ $dept->Dept_name }}">
                            <!-- ... checkbox dan index ... -->
                            <td>
                                {{ $i+1 }}
                            </td>
                            <td>
                                <div class="dept-cell">
                                    <div class="dept-icon-box" style="background:{{ $color }}1a; color:{{ $color }};">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                    <div>
                                        <!-- Menggunakan Object DB: $dept->Dept_name -->
                                        <div class="dept-name-text">{{ $dept->Dept_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="emp-count-chip">
                                    <i class="fa-solid fa-users" style="font-size:10px;"></i>
                                    <!-- Jika ada relasi: $dept->employees_count, jika tidak isi 0 sementara -->
                                    {{ $dept->employees_count ?? 0 }} employees
                                </span>
                            </td>
                            <!-- ... kolom action pastikan memanggil $dept->id dan $dept->Dept_name ... -->
                            <td style="text-align:center;">
                            <div class="action-group" style="justify-content:center;">
                                <button class="btn-act btn-act-edit"
                                        title="Edit Department"
                                        data-action="edit"
                                        data-id="{{ $dept->id }}"
                                        data-name="{{ $dept->Dept_name }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn-act btn-act-del"
                                        title="Delete Department"
                                        data-action="delete"
                                        data-id="{{ $dept->id }}"
                                        data-name="{{ $dept->Dept_name }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data departemen.</td>
                        </tr>
                    @endforelse
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
                {{ $departments->links('pagination::bootstrap-4') }} <!-- Sesuaikan dengan view pagination Anda -->
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