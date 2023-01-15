<?php

namespace App\Http\Resources\Exam;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingExamResource extends JsonResource
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
            'name' => $this->name,
            'start_date' => Carbon::parse($this->start_date)->format('d M, Y'),
            'end_date' => Carbon::parse($this->end_date)->format('d M, Y'),
            'days_left' => Carbon::parse($this->start_date)->diffInDays(),
        ];
    }
}
