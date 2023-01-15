<?php

namespace App\Http\Resources\Exam;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamScheduleResource extends JsonResource
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
            'id'            =>  $this->id,
            'name'            =>  $this->name,
            'session_id'          =>  $this->session_id,
            'exam_id'          =>  $this->exam_id,
            'room_id'          =>  $this->room_id,
            'class_id'          =>  $this->class_id,
            'subject_id'          =>  $this->subject_id,
            'section_id'          =>  $this->section_id,
            'exam_date'          =>  $this->exam_date,
            'start_time'          =>  $this->start_time,
            'end_time'          =>  $this->end_time,
            'note'          =>  $this->note,
            'exam'          => $this->whenLoaded('exam', function(){
                return new ExamResource($this->exam);
            }),
            'subject'          => $this->whenLoaded('subject', function(){
                return $this->subject;
            }),
            'section'          => $this->whenLoaded('section', function(){
                return $this->section;
            }),
            'classs'          => $this->whenLoaded('classs', function(){
                return $this->classs;
            }),
            'room'          => $this->whenLoaded('room', function(){
                return $this->room;
            }),
            'created_at'        =>  $this->created_at,
        ];
    }
}
