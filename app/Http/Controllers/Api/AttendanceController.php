<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\BulkAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Services\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceService $attendanceService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $query = Attendance::with('student');

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => AttendanceResource::collection($attendances),
            'meta' => [
                'current_page' => $attendances->currentPage(),
                'last_page' => $attendances->lastPage(),
                'per_page' => $attendances->perPage(),
                'total' => $attendances->total()
            ]
        ]);
    }

    public function store(StoreAttendanceRequest $request): JsonResponse
    {
        $attendance = Attendance::create($request->validated());
        $attendance->load('student');

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded successfully',
            'data' => new AttendanceResource($attendance)
        ], 201);
    }

    public function bulkStore(BulkAttendanceRequest $request): JsonResponse
    {
        $results = $this->attendanceService->recordBulkAttendance(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Bulk attendance recorded successfully',
            'data' => AttendanceResource::collection($results)
        ], 201);
    }

    public function monthlyReport(Request $request): JsonResponse
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'class' => 'nullable|string'
        ]);

        $report = $this->attendanceService->getMonthlyReport(
            $request->month,
            $request->class
        );

        return response()->json([
            'success' => true,
            'data' => $report
        ]);
    }

    public function statistics(Request $request): JsonResponse
    {
        $request->validate([
            'class' => 'nullable|string',
            'section' => 'nullable|string'
        ]);

        $stats = $this->attendanceService->getAttendanceStatistics(
            $request->class,
            $request->section
        );

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
