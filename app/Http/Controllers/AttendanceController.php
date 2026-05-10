<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Provider\Node\RandomNodeProvider;
use Ramsey\Uuid\Uuid;

class AttendanceController extends Controller
{

    public function index(Request $request)
    {
        // select date range
        $dateFrom = $request->input('date_from', date('Y-m-01'));
        $dateTo   = $request->input('date_to', date('Y-m-d'));

        // Query utama to attendance
        $query = Attendance::query()
            ->select('id', 'Employee_id', 'Time_in', 'Time_out')
            ->with(['employee:id,Full_name,NIK'])
            ->orderBy('Time_in', 'desc');

        // Filter by date range (Time_in)
        $query->whereBetween('Time_in', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        // Filter search (Nama atau NIK)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('Full_name', 'ilike', '%' . $search . '%') // ilike untuk PostgreSQL (case-insensitive)
                    ->orWhere('NIK', 'ilike', '%' . $search . '%');
            });
        }
        // 5. Paginate result
        $attendances = $query->paginate(15)->withQueryString();
        // dd($attendances);
        return view('attendance.index', compact('attendances', 'dateFrom', 'dateTo'));
    }

    /**
     * IMPORT DATA EXCEL VIA AJAX
     */
    public function import(Request $request)
    {
        $request->validate([
            'records' => 'required|array',
        ]);

        $records = $request->records;

        $niks = collect($records)->pluck('employee_nik')->unique()->filter()->toArray();

        if (empty($niks)) {
            return response()->json(['message' => 'Tidak ada NIK yang valid di dalam file.'], 400);
        }

        $employeeMap = Employee::whereIn('NIK', $niks)->pluck('id', 'NIK')->toArray();

        $insertData = [];

        foreach ($records as $row) {
            if (!isset($employeeMap[$row['employee_nik']])) {
                continue;
            }

            $employeeId = $employeeMap[$row['employee_nik']];

            // validation
            $timeIn = !empty($row['time_in'])
                ? Carbon::parse($row['time_in'])->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s')
                : null;

            $timeOut = !empty($row['time_out'])
                ? Carbon::parse($row['time_out'])->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s')
                : null;

            // If 'time_in' is required, make sure it is not null before adding it to the array
            if ($timeIn) {
                $insertData[] = [
                    'id'          => Uuid::uuid6(
                        (new RandomNodeProvider())->getNode(),
                        null
                    )->toString(),
                    'Employee_id' => $employeeId,
                    'Time_in'     => $timeIn,
                    'Time_out'    => $timeOut,
                ];
            }
        }

        if (empty($insertData)) {
            return response()->json(['message' => 'Gagal! Semua NIK di Excel tidak ditemukan di database atau format waktu salah.'], 400);
        }

        // 4. BULK INSERT with CHUNK + INSERT OR IGNORE
        $chunks = array_chunk($insertData, 500);

        DB::beginTransaction();
        try {
            foreach ($chunks as $chunk) {
                DB::table('Attendance')->insertOrIgnore($chunk);
            }
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil diimport!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan sistem saat menyimpan ke database: ' . $e->getMessage()
            ], 500);
        }
    }
}
