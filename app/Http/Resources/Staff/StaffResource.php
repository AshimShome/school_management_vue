<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\Department\DepartmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'id'        =>  $this->id,
            'user_id'   =>  $this->user_id,
            'designation'   =>  $this->designation,
            'department_id'   =>  $this->department_id,
            'joining_date'   =>  $this->joining_date,
            'present_address'   =>  $this->present_address,
            'permanent_address'   =>  $this->permanent_address,
            'phone'   =>  $this->phone,
            'gender'   =>  $this->gender,
            'religion'   =>  $this->religion,
            'bio'   =>  $this->bio,
            'joining_letter'   =>  $this->joining_letter,
            'resume'   =>  $this->resume,
            'other_document'   =>  $this->other_document,
            'created_at'   =>  $this->created_at,
            'user'      =>  $this->whenLoaded('user', function () {
                return $this->user;
            }),
            'department'   =>   $this->whenLoaded('department', function () {
                return new DepartmentResource($this->department);
            })

        ];
    }
}
