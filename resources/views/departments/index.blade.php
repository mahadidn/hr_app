@extends('layouts.app')

@section('title', 'Department Management — NexaHR')
@section('page_title', 'Department Management')

@section('css')
    <link href="{{ asset('css/department.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- ===================== HEADER AREA ===================== --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-primary-custom">Department Management</h4>
            <p class="text-muted-custom mb-0" style="font-size: 13.5px;">Kelola struktur divisi dan departemen perusahaan.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddDepartment" style="background-color: var(--accent); border: none;">
                <i class="fa-solid fa-plus me-2"></i> Add New Department
            </button>
        </div>
    </div>

    {{-- ===================== CARD KONTEN UTAMA ===================== --}}
    <div class="card card-enterprise border-0">
        
        {{-- Area Search --}}
        <div class="filter-wrapper">
            <form action="{{ url('/departments') }}" method="GET">
                <div class="d-flex justify-content-end">
                    <div class="search-input-wrap w-100" style="max-width: 350px;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" class="form-control text-primary-custom bg-input" placeholder="Search by Department Name..." value="{{ request('search') }}">
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-enterprise mb-0 align-middle">
                <thead>
                    <tr>
                        <th width="75%">Department Name</th>
                        <th width="25%" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    {{-- BARIS 1 (Data Dummy) --}}
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="btn-action" style="background-color: rgba(79, 110, 247, 0.1); color: var(--accent); pointer-events: none;">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <span>Information Technology (IT)</span>
                            </div>
                        </td>
                        <td class="text-end">
                            {{-- Action 1: View (Redirect to Employees filtered by this Department ID) --}}
                            <a href="{{ url('/employees?dept_id=1') }}" class="btn-action btn-action-view me-1" title="Lihat Karyawan">
                                <i class="fa-solid fa-users"></i>
                            </a>
                            {{-- Action 2: Edit (Buka Modal Edit) --}}
                            <button type="button" class="btn-action btn-action-edit me-1" data-bs-toggle="modal" data-bs-target="#modalEditDepartment" title="Edit Departemen">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            {{-- Action 3: Delete (Form SweetAlert) --}}
                            <form action="#" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Hapus Departemen">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    {{-- BARIS 2 (Data Dummy) --}}
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="btn-action" style="background-color: rgba(79, 110, 247, 0.1); color: var(--accent); pointer-events: none;">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <span>Finance & Accounting</span>
                            </div>
                        </td>
                        <td class="text-end">
                            <a href="{{ url('/employees?dept_id=2') }}" class="btn-action btn-action-view me-1" title="Lihat Karyawan">
                                <i class="fa-solid fa-users"></i>
                            </a>
                            <button type="button" class="btn-action btn-action-edit me-1" data-bs-toggle="modal" data-bs-target="#modalEditDepartment" title="Edit Departemen">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <form action="#" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Hapus Departemen">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- Pagination Area --}}
        <div class="p-3 border-top d-flex justify-content-between align-items-center text-muted-custom" style="font-size: 13px; border-color: var(--border-color) !important;">
            <div>Showing 1 to 5 of 18 entries</div>
            <div>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

{{-- ==============================================================================
     AREA MODALS
============================================================================== --}}

{{-- 1. MODAL ADD NEW DEPARTMENT --}}
<div class="modal fade enterprise-modal" id="modalAddDepartment" tabindex="-1" aria-labelledby="modalAddDeptTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ url('/departments') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddDeptTitle"><i class="fa-solid fa-folder-plus me-2 text-accent"></i>Add New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary-custom fw-semibold mb-2" style="font-size: 13px;">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="Dept_name" class="form-control bg-input text-primary-custom" maxlength="50" placeholder="Contoh: Production Dept" required autofocus>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--accent); border: none;">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. MODAL EDIT DEPARTMENT --}}
<div class="modal fade enterprise-modal" id="modalEditDepartment" tabindex="-1" aria-labelledby="modalEditDeptTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditDeptTitle"><i class="fa-solid fa-pen-to-square me-2" style="color: var(--warning);"></i>Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary-custom fw-semibold mb-2" style="font-size: 13px;">Department Name <span class="text-danger">*</span></label>
                        {{-- Value di-hardcode sementara untuk simulasi --}}
                        <input type="text" name="Dept_name" class="form-control bg-input text-primary-custom" maxlength="50" value="Information Technology (IT)" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning text-white">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {

    // SweetAlert2 Konfirmasi Hapus Data Departemen
    $('.form-delete').on('submit', function(e) {
        e.preventDefault(); 
        
        var form = this; 

        Swal.fire({
            title: 'Hapus Departemen?',
            text: "Pastikan tidak ada karyawan yang tersisa di dalam departemen ini sebelum menghapusnya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f05252', 
            cancelButtonColor: '#6b7280', 
            confirmButtonText: '<i class="fa-solid fa-trash-can me-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'swal2-popup'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form ke controller
                form.submit();
            }
        });
    });

});
</script>
@endsection