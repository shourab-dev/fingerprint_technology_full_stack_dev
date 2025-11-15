<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $studentId = $this->route('student');

        return [
            'name' => 'sometimes|required|string|max:255',
            'student_id' => "sometimes|required|string|unique:students,student_id,{$studentId}|max:50",
            'class' => 'sometimes|required|string|max:50',
            'section' => 'sometimes|required|string|max:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
