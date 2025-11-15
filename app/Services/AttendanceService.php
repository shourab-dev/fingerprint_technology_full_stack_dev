<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Student;
use App\Events\AttendanceRecorded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AttendanceService
{
    /**
     * Record Bulk Attendence
     * @param array $data
     * @return array $results
     */
    public function recordBulkAttendance(array $data): array
    {
        $date = $data['date'];
        $recordedBy = $data['recorded_by'];
        $attendances = $data['attendances'];

        $results = DB::transaction(function () use ($date, $recordedBy, $attendances) {
            $created = [];

            foreach ($attendances as $attendanceData) {
                $attendance = Attendance::updateOrCreate(
                    [
                        'student_id' => $attendanceData['student_id'],
                        'date' => $date
                    ],
                    [
                        'status' => $attendanceData['status'],
                        'note' => $attendanceData['note'] ?? null,
                        'recorded_by' => $recordedBy
                    ]
                );

                $created[] = $attendance;

                // Fire event for notification
                event(new AttendanceRecorded($attendance));
            }

            return $created;
        });

        // Clear cache
        $this->clearAttendanceCache();

        return $results;
    }

    /**
     * Generate Attendance Monthly Report of Students
     * @param string $month
     * @param string|null $class
     * @param string|null $student_id
     */
    public function getMonthlyReport($month, $class = null, $student_id = null)
    {
        $cacheKey = "attendance_report_{$month}_" . ($class ?? 'all');

        return Cache::remember($cacheKey, 3600, function () use ($month, $class, $student_id) {
            $query = Student::query()->with(['attendances' => function ($query) use ($month) {
                $query->whereMonth('date', '=', date('m', strtotime($month)))
                    ->whereYear('date', '=', date('Y', strtotime($month)));
            }]);

            if ($class) {
                $query->where('class', $class);
            }
            if ($student_id) {
                $query->where('student_id', $student_id);
            }

            $students = $query->get();

            return $students->map(function ($student) use ($month) {
                $attendances = $student->attendances;
                $total = $attendances->count();
                $present = $attendances->where('status', 'present')->count();
                $absent = $attendances->where('status', 'absent')->count();
                $late = $attendances->where('status', 'late')->count();

                return [
                    'student_id' => $student->student_id,
                    'name' => $student->name,
                    'class' => $student->class,
                    'section' => $student->section,
                    'total_days' => $total,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'attendance_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0
                ];
            });
        });
    }

    /**
     * Get Attendance Stats 
     * @param string|null $class
     * @param string|null $section
     * @return array
     */
    public function getAttendanceStatistics($class = null, $section = null): array
    {
        $cacheKey = "attendance_stats_" . ($class ?? 'all') . "_" . ($section ?? 'all');

        return Cache::remember($cacheKey, 1800, function () use ($class, $section) {
            $query = Attendance::query();

            if ($class || $section) {
                $query->whereHas('student', function ($q) use ($class, $section) {
                    if ($class) $q->where('class', $class);
                    if ($section) $q->where('section', $section);
                });
            }

            $total = $query->count();
            $present = (clone $query)->where('status', 'present')->count();
            $absent = (clone $query)->where('status', 'absent')->count();
            $late = (clone $query)->where('status', 'late')->count();
            $excused = (clone $query)->where('status', 'excused')->count();

            return [
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'excused' => $excused,
                'present_percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0
            ];
        });
    }

    protected function clearAttendanceCache(): void
    {
        Cache::flush(); // In production, use more specific cache clearing
    }
}
