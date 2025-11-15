<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::paginate(15);

        return response()->json([
            'success' => true,
            'data' => StudentResource::collection($students),
            'meta' => [
                'current_page' => $students->currentPage(),
                'last_page' => $students->lastPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total()
            ]
        ]);
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student = Student::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => new StudentResource($student)
        ], 201);
    }

    public function show(Student $student): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new StudentResource($student)
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => new StudentResource($student)
        ]);
    }

    public function destroy(Student $student): JsonResponse
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully'
        ]);
    }
}
