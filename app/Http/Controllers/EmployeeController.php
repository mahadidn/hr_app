<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua departemen untuk Dropdown & Filter
        $departments = Department::select('id', 'Dept_name')->orderBy('Dept_name', 'asc')->get();

        // 2. Query Employee beserta data departemennya (Eager Loading)
        $query = Employee::with('department');

        // Filter berdasarkan pencarian NIK / Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('Full_name', 'like', '%' . $search . '%')
                    ->orWhere('NIK', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan Dropdown Departemen
        if ($request->filled('Dept_id')) {
            $query->where('Dept_id', $request->Dept_id);
        }

        // 3. Paginate data
        $employees = $query->paginate(10)->withQueryString();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NIK' => 'required|string|max:13|unique:Employee,NIK',
            'Full_name' => 'required|string|max:50',
            'Dept_id' => 'required|exists:Department,id',
            'Designation' => 'required|string|max:50',
            'Gender' => 'required|in:Male,Female',
            'Phone_no' => 'nullable|string|max:13',
            'Birth_place' => 'required|string|max:50',
            'Birth_date' => 'required|date',
            'Join_date' => 'required|date',
            'Join_end' => 'nullable|date|after_or_equal:Join_date',
        ]);

        Employee::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Karyawan berhasil disimpan.'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'NIK' => [
                'required',
                'string',
                'max:13',
                Rule::unique('Employee', 'NIK')->ignore($employee->id)
            ],
            'Full_name' => 'required|string|max:50',
            'Dept_id' => 'required|exists:Department,id',
            'Designation' => 'required|string|max:50',
            'Gender' => 'required|in:Male,Female',
            'Phone_no' => 'nullable|string|max:13',
            'Birth_place' => 'required|string|max:50',
            'Birth_date' => 'required|date',
            'Join_date' => 'required|date',
            'Join_end' => 'nullable|date|after_or_equal:Join_date',
        ]);

        $employee->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data karyawan berhasil diperbarui.'
        ], 200);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Karyawan berhasil dihapus.'
        ], 200);
    }
}
