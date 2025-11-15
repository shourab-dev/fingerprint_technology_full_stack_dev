<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'date' => $this->date->toDateString(),
            'status' => $this->status,
            'note' => $this->note,
            'recorded_by' => $this->recorded_by,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
