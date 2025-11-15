<?php

namespace App\Listeners;

use App\Events\AttendanceRecorded;
use Illuminate\Support\Facades\Log;

class SendAttendanceNotification
{
    public function handle(AttendanceRecorded $event): void
    {
        $attendance = $event->attendance;

        Log::info("Attendance recorded for student: {$attendance->student_id} on {$attendance->date}");

        //If student is absent follow up email 
        if ($attendance->status === 'absent') {
            $message = "Dear Parent/Guardian, we would like to inform you that your child (Student ID: {$attendance->student_id}) was marked absent on {$attendance->date}. Please ensure they are safe and kindly notify the (Testing from Fingerprint Technologies) if there is a valid reason for the absence.";
            Log::info("$message.Absent notification sent for student: {$attendance->student_id} on {$attendance->date}");
        }
    }
}
