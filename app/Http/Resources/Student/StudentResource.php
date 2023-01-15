<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'id'                    =>  $this->id,
            'user_id'               =>  $this->user_id,
            'parent_id'             =>  $this->parent_id,
            'session_id'              =>  $this->session_id,
            'class_id'              =>  $this->class_id,
            'section_id'              =>  $this->section_id,
            'phone'                 =>  $this->phone,
            'roll_no'               =>  $this->roll_no,
            'admission_date'        =>  $this->admission_date,
            'gender'                =>  $this->gender,
            'date_of_birth'         =>  $this->date_of_birth,
            'blood_group'           =>  $this->blood_group,
            'user'                  =>  $this->whenLoaded('user', function () {
                return $this->user;
            }),
            'guardian'                  =>  $this->whenLoaded('guardian', function () {
                return $this->guardian;
            }),
            'classs'                  =>  $this->whenLoaded('classs', function () {
                return $this->classs;
            }),
            'section'                  =>  $this->whenLoaded('section', function () {
                return $this->section;
            }),
            'created_add'           =>  $this->created_at,
        ];
    }
}
