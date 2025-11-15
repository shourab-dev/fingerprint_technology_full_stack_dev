<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:students,student_id|max:50',
            'class' => 'required|string|max:50',
            'section' => 'required|string|max:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }
}
