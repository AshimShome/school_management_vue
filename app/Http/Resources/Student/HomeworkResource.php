<?php

namespace App\Http\Resources\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'    =>  $this->id,
            'title'  =>  $this->title,
            'teacher_id'  =>  $this->teacher_id,
            'session_id'  =>  $this->session_id,
            'class_id'  =>  $this->class_id,
            'section_id'  =>  $this->section_id,
            'subject_id'  =>  $this->subject_id,
            'start_date'  =>  $this->start_date,
            'end_date'  =>  $this->end_date,
            'description'  =>  $this->description,
        ];
    }
}
