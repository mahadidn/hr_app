@extends('layouts.app')

@section('title', 'Attendance Management')
@section('page_title', 'Attendance Management')

{{-- ================================================================
     PAGE CSS
================================================================ --}}
@section('css')
    <link href="{{ asset('css/attendance.css') }}" rel="stylesheet">
@endsection


{{-- ================================================================
     CONTENT
================================================================ --}}
@section('content')

    {{-- Page Header --}}
    <div class="att-page-header">
        <div>
            <div class="att-page-eyebrow">
                <span class="pulse-dot"></span>
                Workforce Tracking
            </div>
            <h1 class="att-heading">Attendance Management</h1>
            <p class="att-subheading">Pantau dan kelola kehadiran karyawan secara real-time.</p>
        </div>
        <div class="header-actions">
            <button class="btn-header-action primary" id="btnGoImport">
                <i class="fa-solid fa-file-import"></i> Import Excel
            </button>
        </div>
    </div>

    {{-- ======================== PILL TABS ======================== --}}
    <div class="att-tabs-wrap">
        <button class="att-tab-btn active" data-tab="records">
            <span class="tab-icon"><i class="fa-solid fa-table-list"></i></span>
            Attendance Record
            <span class="tab-count">248</span>
        </button>
        <button class="att-tab-btn" data-tab="import" id="tabImportBtn">
            <span class="tab-icon"><i class="fa-solid fa-file-arrow-up"></i></span>
            Import Data
            <span class="tab-count">0</span>
        </button>
    </div>

    {{-- ================================================================
         TAB 1 — ATTENDANCE RECORD
    ================================================================ --}}
    <div class="att-tab-panel active" id="panel-records">

        {{-- Filter Bar --}}
        <div class="att-card mb-3">
            <div class="att-card-body">
                <div class="filter-bar">

                    <div class="filter-group">
                        <label class="filter-label"><i class="fa-solid fa-calendar-days me-1"></i> Tanggal Mulai</label>
                        <input type="date" class="filter-input" id="filterDateFrom"
                               value="{{ date('Y-m-01') }}" style="min-width:155px;">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label"><i class="fa-solid fa-calendar-days me-1"></i> Tanggal Akhir</label>
                        <input type="date" class="filter-input" id="filterDateTo"
                               value="{{ date('Y-m-d') }}" style="min-width:155px;">
                    </div>

                    <div class="filter-group" style="flex:1; min-width:200px;">
                        <label class="filter-label"><i class="fa-solid fa-magnifying-glass me-1"></i> Cari Karyawan</label>
                        <div class="search-wrap">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" class="search-input" id="searchEmployee"
                                   placeholder="Nama atau NIK...">
                        </div>
                    </div>

                    <button class="btn-filter-apply" id="btnApplyFilter">
                        <i class="fa-solid fa-filter"></i> Filter
                    </button>
                    <button class="btn-filter-reset" id="btnResetFilter">
                        <i class="fa-solid fa-xmark"></i> Reset
                    </button>

                </div>
            </div>
        </div>

        {{-- Data Table Card --}}
        <div class="att-card">

            <div class="att-card-header">
                <div class="att-card-title">
                    <span class="title-icon"><i class="fa-solid fa-calendar-check"></i></span>
                    Attendance Data &mdash;
                    <span style="color:var(--text-muted);font-weight:500;font-size:13px;">
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </span>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <button class="btn-header-action">
                        <i class="fa-solid fa-rotate-right"></i> Refresh
                    </button>
                    <button class="btn-header-action">
                        <i class="fa-solid fa-file-excel"></i> Export
                    </button>
                </div>
            </div>

            <div class="table-wrap">
                <table class="att-table" id="attendanceTable">
                    <thead>
                        <tr>
                            <th style="width:40px; padding-left:20px;">
                                <input type="checkbox" id="checkAll" style="accent-color:var(--accent);width:15px;height:15px;">
                            </th>
                            <th class="sortable" data-col="name">
                                Employee Name <i class="fa-solid fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-col="nik">
                                NIK <i class="fa-solid fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-col="timein">
                                Time In <i class="fa-solid fa-sort sort-icon"></i>
                            </th>
                            <th class="sortable" data-col="timeout">
                                Time Out <i class="fa-solid fa-sort sort-icon"></i>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTbody">
                        @forelse($attendances as $att)
                            @php
                                // Buat inisial untuk avatar
                                $words = explode(' ', $att->employee->full_name ?? 'N A');
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            @endphp
                            <tr>
                                <td style="padding-left:20px;">
                                    <input type="checkbox" class="row-check" style="accent-color:var(--accent);width:15px;height:15px;">
                                </td>
                                <td>
                                    <div class="emp-cell">
                                        <div class="emp-avatar" style="background:linear-gradient(135deg,#4f6ef7,#7c3aed);">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="emp-name">{{ $att->employee->Full_name ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="nik-mono">{{ $att->employee->NIK ?? '-' }}</span></td>
                                <td>
                                    <span class="time-val">
                                        {{ $att->Time_in ? \Carbon\Carbon::parse($att->Time_in)->format('Y-m-d H:i') : '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="time-val">
                                        {{ $att->Time_out ? \Carbon\Carbon::parse($att->Time_out)->format('Y-m-d H:i') : '—' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                    <i class="fa-solid fa-calendar-xmark" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                                    No attendance data was found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Table Footer / Pagination --}}
            <div class="table-footer">
                <div class="table-info">
                    Menampilkan <strong>1–5</strong> dari <strong>248</strong> data
                </div>
                <div class="pagination-wrap">
                    <button class="pg-btn"><i class="fa-solid fa-chevron-left" style="font-size:10px;"></i></button>
                    <button class="pg-btn active">1</button>
                    <button class="pg-btn">2</button>
                    <button class="pg-btn">3</button>
                    <span style="padding:0 4px;display:flex;align-items:center;color:var(--text-muted);font-size:12px;">…</span>
                    <button class="pg-btn">50</button>
                    <button class="pg-btn"><i class="fa-solid fa-chevron-right" style="font-size:10px;"></i></button>
                </div>
            </div>

        </div>
        {{-- END Table Card --}}

    </div>
    {{-- END TAB 1 --}}


    {{-- ================================================================
         TAB 2 — IMPORT DATA
    ================================================================ --}}
    <div class="att-tab-panel" id="panel-import">

        <div class="import-grid">

            {{-- LEFT: Upload zone + instructions --}}
            <div class="upload-panel">

                <div class="att-card">
                    <div class="att-card-header">
                        <div class="att-card-title">
                            <span class="title-icon"><i class="fa-solid fa-file-arrow-up"></i></span>
                            Upload File Excel
                        </div>
                    </div>
                    <div class="att-card-body">

                        {{-- DROP ZONE --}}
                        <div class="dropzone" id="dropzone">
                            <input type="file" id="excelFileInput" accept=".xlsx,.xls,.csv">

                            {{-- Default state --}}
                            <div id="dzDefault">
                                <div class="dz-icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <div class="dz-main-text">Drag &amp; Drop file here</div>
                                <div class="dz-sub-text">
                                    or <strong>click to select a file </strong><br>
                                    from your computer
                                </div>
                                <div class="dz-divider"></div>
                                <div class="dz-types">
                                    <span class="type-chip">
                                        <i class="fa-solid fa-file-excel" style="color:#0ea66e;"></i> .xlsx
                                    </span>
                                    <span class="type-chip">
                                        <i class="fa-solid fa-file-excel" style="color:#0ea66e;"></i> .xls
                                    </span>
                                    <span class="type-chip">
                                        <i class="fa-solid fa-file-csv" style="color:#0284c7;"></i> .csv
                                    </span>
                                </div>
                            </div>

                            {{-- File chosen state (hidden) --}}
                            <div id="dzChosen" style="display:none;">
                                <div class="dz-icon">
                                    <i class="fa-solid fa-file-circle-check"></i>
                                </div>
                                <div class="dz-file-chosen" style="display:flex;">
                                    <div class="dz-chosen-name" id="chosenFileName"></div>
                                    <div class="dz-chosen-size" id="chosenFileSize"></div>
                                    <span class="dz-change-link" id="dzChangeLink">Change file</span>
                                </div>
                            </div>
                        </div>

                        {{-- Download Template --}}
                        {{-- <div class="template-row">
                            <div class="template-row-left">
                                <div class="template-icon">
                                    <i class="fa-solid fa-file-excel"></i>
                                </div>
                                <div>
                                    <div class="template-text-main">Template Excel</div>
                                    <div class="template-text-sub">Format standar untuk import data absensi</div>
                                </div>
                            </div>
                            <a href="{{ url('/attendance/template/download') }}"
                               class="btn-download-template"
                               id="btnDownloadTemplate"
                               title="Download Template Excel">
                                <i class="fa-solid fa-arrow-down-to-line"></i>
                                Download Template
                            </a>
                        </div> --}}

                    </div>
                </div>

            </div>
            {{-- END LEFT --}}

            {{-- RIGHT: Instructions --}}
            <div class="import-steps-panel">
                <div class="steps-title">
                    <i class="fa-solid fa-circle-info" style="color:var(--accent-text);"></i>
                    Data Import Guide
                </div>

                <div class="step-item">
                    <div class="step-num">1</div>
                    <div>
                        <div class="step-text-main">Adjust the data columns</div>
                        <div class="step-text-sub">Align the Excel columns using the Excel column mapping tutorial below.</div>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div>
                        <div class="step-text-main">Upload &amp; Preview</div>
                        <div class="step-text-sub">Select a file, and the system will display a preview of the data before saving it to the database.</div>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-num">3</div>
                    <div>
                        <div class="step-text-main">Submit to Database</div>
                        <div class="step-text-sub">Review the preview data, then click the “Submit to Database” button to save.</div>
                    </div>
                </div>

                {{-- Column mapping table --}}
                <div style="margin-top:20px; border-top:1px solid var(--border-color); padding-top:16px; transition:border-color .3s;">
                    <div style="font-size:11.5px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:10px;">
                        Excel Column Mapping Tutorial
                    </div>
                    <table class="col-map-table">
                        <thead>
                            <tr>
                                <th>Column Name</th>
                                <th>Description</th>
                                <th>Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>employee_nik</td>
                                <td style="font-family:var(--font-main);">Employee's NIK</td>
                                <td><span class="req-pill">Required</span></td>
                            </tr>
                            <tr>
                                <td>time_in</td>
                                <td style="font-family:var(--font-main);">Format: YYYY-MM-DD HH:MM</td>
                                <td><span class="req-pill">Required</span></td>
                            </tr>
                            <tr>
                                <td>time_out</td>
                                <td style="font-family:var(--font-main);">Format: YYYY-MM-DD HH:MM</td>
                                <td><span class="opt-pill">Optional</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- END RIGHT --}}

        </div>
        {{-- END import-grid --}}


        {{-- ============================================================
             PREVIEW CONTAINER — hidden until file parsed
        ============================================================ --}}
        <div id="previewContainer" class="att-card d-none preview-section">

            <div class="preview-header">
                <div class="preview-title">
                    <i class="fa-solid fa-table-cells-large" style="color:var(--accent-text);"></i>
                    Data Preview
                    <span class="preview-badge" id="previewRowCount">0 baris</span>
                </div>
                <div class="preview-meta">
                    <span><i class="fa-solid fa-file-excel" style="color:#0ea66e;"></i> <span id="previewFileName">-</span></span>
                    <span><i class="fa-solid fa-columns"></i> <span id="previewColCount">0</span> kolom</span>
                    <span><i class="fa-solid fa-clock"></i> Parsed: <span id="previewTime">-</span></span>
                </div>
            </div>

            <div class="preview-table-wrap">
                <table id="previewTable">
                    <thead id="previewThead"></thead>
                    <tbody id="previewTbody"></tbody>
                </table>
            </div>

            <div class="preview-footer">
                <div class="preview-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Periksa data dengan seksama sebelum menyimpan. Proses ini tidak dapat dibatalkan.
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;">
                    <button class="btn-discard" id="btnDiscardPreview">
                        <i class="fa-solid fa-xmark"></i> Buang
                    </button>
                    <button id="btnSubmitAttendance">
                        <i class="fa-solid fa-database"></i>
                        Submit to Database
                    </button>
                </div>
            </div>

        </div>
        {{-- END previewContainer --}}

    </div>
    {{-- END TAB 2 --}}

@endsection


{{-- ================================================================
     SCRIPTS
================================================================ --}}
@section('scripts')

{{-- SheetJS (XLSX) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
$(function () {

    /* ==============================================================
       1. TAB SWITCHING
    ============================================================== */
    $('.att-tab-btn').on('click', function () {
        var tab = $(this).data('tab');

        // Update buttons
        $('.att-tab-btn').removeClass('active');
        $(this).addClass('active');

        // Update panels
        $('.att-tab-panel').removeClass('active');
        $('#panel-' + tab).addClass('active');
    });

    // Quick shortcut: "Import Excel" header button → switch to import tab
    $('#btnGoImport').on('click', function () {
        $('[data-tab="import"]').trigger('click');
    });


    /* ==============================================================
       2. FILTER BAR
    ============================================================== */
    $('#btnApplyFilter').on('click', function () {
        var keyword = $('#searchEmployee').val().trim().toLowerCase();

        // Filter tabel (simulasi client-side — ganti dengan AJAX di produksi)
        $('#attendanceTbody tr').each(function () {
            var name = $(this).find('.emp-name').text().toLowerCase();
            var nik  = $(this).find('.nik-mono').text().toLowerCase();

            var matchKw = !keyword || name.includes(keyword) || nik.includes(keyword);

            $(this).toggle(matchKw);
        });
    });

    $('#btnResetFilter').on('click', function () {
        $('#filterDateFrom').val('{{ date("Y-m-01") }}');
        $('#filterDateTo').val('{{ date("Y-m-d") }}');
        $('#searchEmployee').val('');
        $('#attendanceTbody tr').show();
    });

    // Live search on keyup
    $('#searchEmployee').on('keyup', function () {
        if ($(this).val().length === 0) {
            $('#attendanceTbody tr').show();
            return;
        }
        $('#btnApplyFilter').trigger('click');
    });

    // Check-all checkbox
    $('#checkAll').on('change', function () {
        $('.row-check').prop('checked', $(this).is(':checked'));
    });

    // Sortable columns (simple client-side toggle)
    var sortState = {};
    $('.att-table thead th.sortable').on('click', function () {
        var col  = $(this).data('col');
        var asc  = sortState[col] !== 'asc';
        sortState[col] = asc ? 'asc' : 'desc';

        $('.att-table thead th').removeClass('sort-asc sort-desc')
            .find('.sort-icon').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');

        $(this).addClass(asc ? 'sort-asc' : 'sort-desc')
               .find('.sort-icon').removeClass('fa-sort').addClass(asc ? 'fa-sort-up' : 'fa-sort-down');
    });


    /* ==============================================================
       3. DRAG & DROP + FILE INPUT
    ============================================================== */
    var $dropzone  = $('#dropzone');
    var $fileInput = $('#excelFileInput');

    // Drag events
    $dropzone
        .on('dragover dragenter', function (e) {
            e.preventDefault();
            $dropzone.addClass('dragover');
        })
        .on('dragleave dragend drop', function (e) {
            e.preventDefault();
            $dropzone.removeClass('dragover');
        })
        .on('drop', function (e) {
            var files = e.originalEvent.dataTransfer.files;
            if (files && files.length) processFile(files[0]);
        });

    // Click-to-browse (file input sits on top via CSS)
    $fileInput.on('change', function () {
        if (this.files && this.files.length) processFile(this.files[0]);
    });

    // "Ganti file" link
    $('#dzChangeLink').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $fileInput.val('').trigger('click');
    });


    /* ==============================================================
       4. PROCESS FILE WITH SHEETJS
    ============================================================== */
    function processFile(file) {
        // Validate extension
        var ext = file.name.split('.').pop().toLowerCase();
        if (!['xlsx','xls','csv'].includes(ext)) {
            Swal.fire({
                icon: 'error',
                title: 'Format tidak didukung',
                html: 'Hanya file <strong>.xlsx</strong>, <strong>.xls</strong>, dan <strong>.csv</strong> yang diizinkan.',
                confirmButtonColor: '#4f6ef7'
            });
            return;
        }

        // Validate size (max 10 MB)
        if (file.size > 10 * 1024 * 1024) {
            Swal.fire({
                icon: 'warning',
                title: 'File terlalu besar',
                text: 'Ukuran file maksimal 10 MB.',
                confirmButtonColor: '#4f6ef7'
            });
            return;
        }

        // Show "reading" state
        Swal.fire({
            title: 'Membaca File',
            html: 'SheetJS sedang memproses <strong>' + file.name + '</strong>…',
            allowOutsideClick: false,
            didOpen: function () { Swal.showLoading(); }
        });

        var reader = new FileReader();
        reader.onload = function (e) {
            try {
                var data     = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array', cellDates: true, dateNF: 'yyyy-mm-dd hh:mm' });
                var sheetName = workbook.SheetNames[0];
                var sheet    = workbook.Sheets[sheetName];
                var json     = XLSX.utils.sheet_to_json(sheet, { defval: '' });

                Swal.close();

                if (!json || json.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sheet Kosong',
                        text: 'File Excel tidak mengandung data. Pastikan sheet pertama telah diisi.',
                        confirmButtonColor: '#4f6ef7'
                    });
                    return;
                }

                // Update dropzone UI
                updateDropzoneChosen(file);

                // Render preview table
                renderPreview(json, file);

            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Membaca File',
                    text: 'File mungkin rusak atau formatnya tidak sesuai. Detail: ' + err.message,
                    confirmButtonColor: '#4f6ef7'
                });
            }
        };

        reader.onerror = function () {
            Swal.close();
            Swal.fire({ icon:'error', title:'File Error', text:'Gagal membaca file.', confirmButtonColor:'#4f6ef7' });
        };

        reader.readAsArrayBuffer(file);
    }

    /* --- Update dropzone to "chosen" visual state --- */
    function updateDropzoneChosen(file) {
        var sizeLabel = file.size > 1024 * 1024
            ? (file.size / (1024*1024)).toFixed(2) + ' MB'
            : (file.size / 1024).toFixed(1) + ' KB';

        $('#chosenFileName').text(file.name);
        $('#chosenFileSize').text(sizeLabel);
        $('#dzDefault').hide();
        $('#dzChosen').show();
        $dropzone.addClass('has-file');
    }

    /* --- Render preview table from JSON array --- */
    function renderPreview(json, file) {
        var headers = Object.keys(json[0]);
        var now     = new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit' });

        // Build thead
        var theadHtml = '<tr>';
        theadHtml += '<th style="padding-left:16px;">#</th>';
        headers.forEach(function (h) {
            theadHtml += '<th>' + escHtml(h) + '</th>';
        });
        theadHtml += '</tr>';
        $('#previewThead').html(theadHtml);

        // Build tbody — cap display at 200 rows for performance
        var displayRows = json.slice(0, 200);
        var tbodyHtml   = '';
        displayRows.forEach(function (row, i) {
            tbodyHtml += '<tr>';
            tbodyHtml += '<td style="padding-left:16px;color:var(--text-muted);font-size:11.5px;">' + (i + 1) + '</td>';
            headers.forEach(function (h) {
                var val = row[h] !== undefined ? String(row[h]) : '';
                tbodyHtml += '<td>' + escHtml(val) + '</td>';
            });
            tbodyHtml += '</tr>';
        });
        $('#previewTbody').html(tbodyHtml);

        // Update meta
        var rowLabel = json.length > 200
            ? json.length + ' baris (menampilkan 200 pertama)'
            : json.length + ' baris';

        $('#previewRowCount').text(rowLabel);
        $('#previewFileName').text(file.name);
        $('#previewColCount').text(headers.length);
        $('#previewTime').text(now);

        // Update import tab badge count
        $('[data-tab="import"] .tab-count').text(json.length);

        // Store json globally for submit
        window._importJson = json;
        window._importFile = file.name;

        // Show container with animation
        $('#previewContainer').removeClass('d-none');

        // Smooth scroll to preview
        $('html, body').animate({
            scrollTop: $('#previewContainer').offset().top - 80
        }, 450, 'swing');
    }

    /* --- Simple HTML escape helper --- */
    function escHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;');
    }


    /* ==============================================================
       5. DISCARD PREVIEW
    ============================================================== */
    $('#btnDiscardPreview').on('click', function () {
        Swal.fire({
            icon: 'question',
            title: 'Buang Preview?',
            text: 'Data yang sudah di-parse akan dihapus dan Anda perlu mengupload ulang.',
            showCancelButton: true,
            confirmButtonColor: '#f05252',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Buang',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function (result) {
            if (result.isConfirmed) {
                resetImport();
            }
        });
    });

    function resetImport() {
        // Reset dropzone
        $dropzone.removeClass('has-file');
        $('#dzDefault').show();
        $('#dzChosen').hide();
        $fileInput.val('');

        // Hide preview
        $('#previewContainer').addClass('d-none');
        $('#previewThead, #previewTbody').empty();
        $('[data-tab="import"] .tab-count').text('0');

        // Clear global state
        window._importJson = null;
        window._importFile = null;
    }


    /* ==============================================================
       6. SUBMIT TO DATABASE — SweetAlert2 loading simulation
    ============================================================== */
    $('#btnSubmitAttendance').on('click', function () {
        var json = window._importJson;
        if (!json || json.length === 0) {
            Swal.fire({ icon:'warning', title:'Tidak Ada Data', text:'Tidak ada data untuk disimpan.', confirmButtonColor:'#4f6ef7' });
            return;
        }

        // Confirm before submit
        Swal.fire({
            icon: 'question',
            title: 'Simpan ke Database?',
            html: 'Anda akan menyimpan <strong>' + json.length + ' baris</strong> data dari file <strong>' + escHtml(window._importFile || '-') + '</strong>.<br><br>Proses ini tidak dapat dibatalkan.',
            showCancelButton: true,
            confirmButtonColor: '#0ea66e',
            cancelButtonColor:  '#6b7280',
            confirmButtonText:  '<i class="fa-solid fa-database me-1"></i> Ya, Simpan',
            cancelButtonText:   'Batal',
            reverseButtons: true
        }).then(function (confirmed) {
            if (!confirmed.isConfirmed) return;

            // --- LOADING STATE ---
            Swal.fire({
                title: 'Menyimpan Data…',
                html: '<div style="margin-bottom:10px;">Sedang mengimpor <strong>' + json.length + '</strong> record ke database.</div>'
                    + '<div style="font-size:12px;color:#888;">Mohon jangan menutup halaman ini.</div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function () {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route("attendance.import") }}',
                method: 'POST',
                data: JSON.stringify({ records: json }), 
                contentType: 'application/json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Import Berhasil!',
                        html: '<strong>' + json.length + ' baris</strong> berhasil diproses. Data yang valid telah disimpan.',
                        confirmButtonColor: '#0ea66e',
                        confirmButtonText: 'Lihat Data'
                    }).then(function () {
                        // Langsung reload saja agar data tabel Data Kehadiran ter-update dari backend
                        window.location.reload(); 
                    });
                },
                error: function(err) {
                    var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Terjadi kesalahan server.';
                    Swal.fire({ 
                        icon: 'error', 
                        title: 'Import Gagal', 
                        text: msg, 
                        confirmButtonColor: '#f05252' 
                    });
                }
            });

        });
    });


    /* ==============================================================
       7. DOWNLOAD TEMPLATE (intercept & toast)
    ============================================================== */
    $('#btnDownloadTemplate').on('click', function (e) {
        // If you have a real route, remove this handler.
        // This just shows a toast so the demo doesn't 404.
        e.preventDefault();
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: 'Mengunduh template Excel…',
            showConfirmButton: false,
            timer: 2200,
            timerProgressBar: true
        });
    });

});
</script>
@endsection