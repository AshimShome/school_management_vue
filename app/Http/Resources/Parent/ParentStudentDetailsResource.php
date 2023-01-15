<?php

namespace App\Http\Resources\Parent;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentStudentDetailsResource extends JsonResource
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
            'name' => $this->user->name,
            'image' => $this->user->image_url,
            'email' => $this->user->email,
            'class' => $this->classs->name,
            'section' => $this->section->name,
            'roll_no' => $this->roll_no,
            'admission_date' => $this->admission_date,
            'gender' => $this->gender,
            'blood_group' => $this->blood_group,
        ];
    }
}
