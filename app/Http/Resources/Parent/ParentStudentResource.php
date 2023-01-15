<?php

namespace App\Http\Resources\Parent;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_id' => $this->user_id,
            'name' => $this->user->name,
        ];
    }
}
