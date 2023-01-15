<?php

namespace App\Http\Resources\Parent;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentFeesResource extends JsonResource
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
            'student_id' => $this->student->id,
            'student_name' => $this->student->user->name,
            'class_name' => $this->class->name,
            'section_name' => $this->section->name,
            'fee_type' => $this->type->name,
            'amount' => $this->amount,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'pay_date' => $this->pay_date,
        ];
    }
}
