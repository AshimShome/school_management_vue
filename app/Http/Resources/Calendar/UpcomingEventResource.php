<?php

namespace App\Http\Resources\Calendar;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingEventResource extends JsonResource
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
            'title'     =>  $this->event_name,
            'start_date' => Carbon::parse($this->start_date)->format('d M, Y'),
            'end_date' => Carbon::parse($this->end_date)->format('d M, Y'),
            'days_left' => Carbon::parse($this->start_date)->diffInDays(),
        ];
    }
}
