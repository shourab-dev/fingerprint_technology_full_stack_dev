<?php

namespace App\Models;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'student_id',
        'class',
        'section',
        'photo'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function getAttendanceRate($month = null)
    {
        $query = $this->attendances();

        if ($month) {
            $query->whereMonth('date', '=', date('m', strtotime($month)))
                ->whereYear('date', '=', date('Y', strtotime($month)));
        }

        $total = $query->count();
        $present = $query->where('status', 'present')->count();

        return $total > 0 ? round(($present / $total) * 100, 2) : 0;
    }
}
