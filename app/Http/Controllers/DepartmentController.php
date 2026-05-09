<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Displaying the main page with pagination and search features
     */
    public function index(Request $request)
    {
        $departments = Department::query()
            ->when($request->search, function ($query, $search) {
                $query->where('Dept_name', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('departments.index', compact('departments'));
    }

    /**
     * Stored a new department to a database
     */
    public function store(Request $request)
    {
        // input validation
        $request->validate([
            'Dept_name' => 'required|string|max:50|unique:Department,Dept_name'
        ]);

        // stored data
        Department::create([
            'Dept_name' => $request->Dept_name
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'A new department has been added to the system.'
        ]);
    }

    /**
     * Update a department
     */
    public function update(Request $request, $id)
    {
        // input validation
        $request->validate([
            'Dept_name' => 'required|string|max:50|unique:Department,Dept_name,' . $id
        ]);

        $department = Department::findOrFail($id);

        $department->update([
            'Dept_name' => $request->Dept_name
        ]);

        return back()->with('swal', [
            'icon' => 'success',
            'title' => 'Updated!',
            'text',
            'The department name has been successfully updated.'
        ]);
    }

    /**
     * Delete a department
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        // Contoh proteksi jika departemen masih memiliki karyawan
        if ($department->employees()->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed! Please transfer the employees before deleting this department.'
            ], 400);
        }

        $department->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The department has been successfully removed from the system'
        ], 200);
    }
}
