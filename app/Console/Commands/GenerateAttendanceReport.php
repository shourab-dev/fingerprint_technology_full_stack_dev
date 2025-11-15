<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AttendanceService;

class GenerateAttendanceReport extends Command
{
    protected $signature = 'attendance:generate {month} {class?}';
    protected $description = 'Generate attendance report for a specific month and optional class';

    public function handle(AttendanceService $attendanceService): int
    {
        $month = $this->argument('month');
        $class = $this->argument('class');

        $this->info("Generating attendance report for {$month}" . ($class ? " - Class: {$class}" : ""));

        try {
            $report = $attendanceService->getMonthlyReport($month, $class);

            $this->table(
                ['Student ID', 'Name', 'Class', 'Section', 'Total Days', 'Present', 'Absent', 'Late', 'Rate %'],
                $report->map(fn($r) => [
                    $r['student_id'],
                    $r['name'],
                    $r['class'],
                    $r['section'],
                    $r['total_days'],
                    $r['present'],
                    $r['absent'],
                    $r['late'],
                    $r['attendance_rate'] . '%'
                ])
            );

            $this->info('Report generated successfully!');

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error generating report: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
