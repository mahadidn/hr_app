@extends('layouts.app')

@section('title', 'Employee Management — NexaHR')
@section('page_title', 'Employee Management')

@section('css')
    <link href="{{ asset('css/employee.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid px-0">

    {{-- ===================== HEADER AREA ===================== --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1 text-primary-custom">Employee Directory</h4>
            <p class="text-muted-custom mb-0" style="font-size: 13.5px;">Kelola data master seluruh karyawan perusahaan.</p>
        </div>
        <div>
            {{-- Tombol ini sekarang membuka Modal, bukan pindah halaman --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddEmployee" style="background-color: var(--accent); border: none;">
                <i class="fa-solid fa-plus me-2"></i> Add New Employee
            </button>
        </div>
    </div>

    {{-- ===================== CARD KONTEN UTAMA ===================== --}}
    <div class="card card-enterprise border-0">
        
        {{-- Filter & Search Form --}}
        <div class="filter-wrapper">
            <form action="{{ url('/employees') }}" method="GET" id="filterForm">
                <div class="row g-3 justify-content-between">
                    
                    {{-- Dropdown Filter Department --}}
                    <div class="col-12 col-md-4 col-lg-3">
                        <select class="form-select text-secondary-custom bg-input" name="dept_id" id="departmentFilter">
                            <option value="">All Departments</option>
                            <option value="1">Information Technology (IT)</option>
                            <option value="2">Production & Engineering</option>
                            <option value="3">Human Resources</option>
                            <option value="4">Finance & Accounting</option>
                        </select>
                    </div>

                    {{-- Search Input --}}
                    <div class="col-12 col-md-5 col-lg-4">
                        <div class="search-input-wrap">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" name="search" class="form-control text-primary-custom bg-input" placeholder="Search by NIK or Name..." value="{{ request('search') }}">
                        </div>
                    </div>

                </div>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-enterprise mb-0 align-middle">
                <thead>
                    <tr>
                        <th width="20%">Employee</th>
                        <th width="15%">NIK</th>
                        <th width="20%">Department</th>
                        <th width="25%">Designation</th>
                        <th width="20%" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    {{-- BARIS 1 (Data Dummy) --}}
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-circle">AD</div>
                                <div>
                                    <div class="fw-bold text-primary-custom" style="font-size: 14px;">Ardianto Pratama</div>
                                    <div class="text-muted-custom" style="font-size: 12px;">Joined: 12 Jan 2024</div>
                                </div>
                            </div>
                        </td>
                        <td class="fw-mono text-secondary-custom">102024001A</td>
                        <td><span class="badge-dept">IT Department</span></td>
                        <td class="text-secondary-custom">Backend Developer</td>
                        <td class="text-end">
                            {{-- Tombol View --}}
                            <button type="button" class="btn-action btn-action-view me-1" data-bs-toggle="modal" data-bs-target="#modalViewEmployee" title="View Detail">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            {{-- Tombol Edit --}}
                            <button type="button" class="btn-action btn-action-edit me-1" data-bs-toggle="modal" data-bs-target="#modalEditEmployee" title="Edit Data">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            {{-- Tombol Delete --}}
                            <form action="#" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Delete Data">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        {{-- Pagination Area (Dummy) --}}
        <div class="p-3 border-top d-flex justify-content-between align-items-center text-muted-custom" style="font-size: 13px; border-color: var(--border-color) !important;">
            <div>Showing 1 to 10 of 250 entries</div>
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

{{-- 1. MODAL ADD NEW EMPLOYEE --}}
<div class="modal fade enterprise-modal" id="modalAddEmployee" tabindex="-1" aria-labelledby="modalAddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ url('/employees') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddTitle"><i class="fa-solid fa-user-plus me-2 text-accent"></i>Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="NIK" class="form-control bg-input text-primary-custom" maxlength="13" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="Full_name" class="form-control bg-input text-primary-custom" maxlength="50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Department <span class="text-danger">*</span></label>
                            <select name="Dept_id" class="form-select bg-input text-primary-custom" required>
                                <option value="" selected disabled>Select Department</option>
                                <option value="1">IT Department</option>
                                <option value="2">Finance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Designation</label>
                            <input type="text" name="Designation" class="form-control bg-input text-primary-custom" maxlength="50">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Gender <span class="text-danger">*</span></label>
                            <select name="Gender" class="form-select bg-input text-primary-custom" required>
                                <option value="" selected disabled>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Phone No <span class="text-danger">*</span></label>
                            <input type="text" name="Phone_no" class="form-control bg-input text-primary-custom" maxlength="13" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Birth Place <span class="text-danger">*</span></label>
                            <input type="text" name="Birth_place" class="form-control bg-input text-primary-custom" maxlength="50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Birth Date <span class="text-danger">*</span></label>
                            <input type="date" name="Birth_date" class="form-control bg-input text-primary-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Join Date <span class="text-danger">*</span></label>
                            <input type="date" name="Join_date" class="form-control bg-input text-primary-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Join End <span class="text-muted">(Optional)</span></label>
                            <input type="date" name="Join_end" class="form-control bg-input text-primary-custom">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--accent); border: none;">Save Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. MODAL EDIT EMPLOYEE --}}
<div class="modal fade enterprise-modal" id="modalEditEmployee" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {{-- Form action nantinya diarahkan ke route update dengan parameter ID --}}
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTitle"><i class="fa-solid fa-user-pen me-2" style="color: var(--warning);"></i>Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="NIK" class="form-control bg-input text-primary-custom" value="102024001A" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="Full_name" class="form-control bg-input text-primary-custom" value="Ardianto Pratama" required>
                        </div>
                        {{-- Field lainnya sama persis seperti Form Add --}}
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Department <span class="text-danger">*</span></label>
                            <select name="Dept_id" class="form-select bg-input text-primary-custom" required>
                                <option value="1" selected>IT Department</option>
                                <option value="2">Finance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary-custom fw-semibold mb-1" style="font-size: 13px;">Designation</label>
                            <input type="text" name="Designation" class="form-control bg-input text-primary-custom" value="Backend Developer">
                        </div>
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

{{-- 3. MODAL VIEW DETAIL EMPLOYEE --}}
<div class="modal fade enterprise-modal" id="modalViewEmployee" tabindex="-1" aria-labelledby="modalViewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center gap-3">
                <div class="avatar-circle" style="width: 48px; height: 48px; font-size: 18px;">AD</div>
                <div>
                    <h5 class="modal-title mb-0">Mahadi Dwi Nugraha</h5>
                    <div class="text-muted-custom" style="font-size: 13px;">Backend Developer</div>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-6">
                        <div class="view-label">NIK</div>
                        <div class="view-value">102024001A</div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">Department</div>
                        <div class="view-value"><span class="badge-dept">IT Department</span></div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">Gender</div>
                        <div class="view-value">Male</div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">Phone No</div>
                        <div class="view-value">+62 812-3456-7890</div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">Birth Place</div>
                        <div class="view-value">Batam</div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">Date of Birth</div>
                        <div class="view-value">30 Aug 2003</div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">Join Date</div>
                        <div class="view-value">12 Jan 2024</div>
                    </div>
                    <div class="col-6">
                        <div class="view-label">End Date</div>
                        <div class="view-value">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light w-100" data-bs-dismiss="modal">Tutup Detail</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {

    // 1. Auto-submit form filter saat dropdown departemen diganti
    $('#departmentFilter').on('change', function() {
        $('#filterForm').submit();
    });

    // 2. SweetAlert2 Konfirmasi Hapus Data
    $('.form-delete').on('submit', function(e) {
        e.preventDefault(); 
        
        var form = this; 

        Swal.fire({
            title: 'Hapus Data Karyawan?',
            text: "Data yang dihapus tidak dapat dikembalikan beserta riwayat absensinya!",
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
                form.submit();
            }
        });
    });

});
</script>
@endsection