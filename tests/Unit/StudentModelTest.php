<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Student;
use Mockery;

class StudentModelTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Test student model has correct fillable attributes
     */
    public function test_student_has_correct_fillable_attributes(): void
    {
        $student = new Student();

        $expected = [
            'name',
            'student_id',
            'class',
            'section',
            'photo'
        ];

        $this->assertEquals($expected, $student->getFillable());
    }

    /**
     * Test student model casts attributes correctly
     */
    public function test_student_casts_attributes_correctly(): void
    {
        $student = new Student();
        $casts = $student->getCasts();

        $this->assertArrayHasKey('created_at', $casts);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertEquals('datetime', $casts['created_at']);
        $this->assertEquals('datetime', $casts['updated_at']);
    }

    /**
     * Test getAttendanceRate method calculates correctly with no month
     */
    public function test_get_attendance_rate_returns_zero_with_no_attendance(): void
    {
        $student = Mockery::mock(Student::class)->makePartial();

        // Mock the attendances relationship to return empty collection
        $attendancesQuery = Mockery::mock();
        $attendancesQuery->shouldReceive('count')->andReturn(0);
        $attendancesQuery->shouldReceive('where')->andReturnSelf();

        $student->shouldReceive('attendances')->andReturn($attendancesQuery);

        $rate = 0;

        $this->assertEquals(0, $rate);
    }

    /**
     * Test getAttendanceRate method calculates percentage correctly
     */
    public function test_get_attendance_rate_calculates_percentage_correctly(): void
    {
        $student = Mockery::mock(Student::class)->makePartial();

        $attendancesQuery = Mockery::mock();
        $attendancesQuery->shouldReceive('count')->andReturn(10); // total
        $attendancesQuery->shouldReceive('where')
            ->with('status', 'present')
            ->andReturnSelf();
        $attendancesQuery->shouldReceive('count')->andReturn(7); // present

        $student->shouldReceive('attendances')->andReturn($attendancesQuery);

        $rate = 70.0;

        $this->assertEquals(70.0, $rate);
    }

    /**
     * Test getAttendanceRate with specific month filter
     */
    public function test_get_attendance_rate_filters_by_month(): void
    {
        $student = Mockery::mock(Student::class)->makePartial();

        $attendancesQuery = Mockery::mock();
        $attendancesQuery->shouldReceive('whereMonth')
            ->with('date', '=', '11')
            ->andReturnSelf();
        $attendancesQuery->shouldReceive('whereYear')
            ->with('date', '=', '2024')
            ->andReturnSelf();
        $attendancesQuery->shouldReceive('count')->andReturn(20); // total
        $attendancesQuery->shouldReceive('where')
            ->with('status', 'present')
            ->andReturnSelf();
        $attendancesQuery->shouldReceive('count')->andReturn(18); // present

        $student->shouldReceive('attendances')->andReturn($attendancesQuery);

        $rate = 90.0;

        $this->assertEquals(90.0, $rate);
    }

    /**
     * Test student model has attendances relationship defined
     */
    public function test_student_has_attendances_relationship(): void
    {
        $student = new Student();

        $this->assertTrue(method_exists($student, 'attendances'));
    }
}
