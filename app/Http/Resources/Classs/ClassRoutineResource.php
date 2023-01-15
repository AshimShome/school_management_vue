<?php

namespace App\Http\Resources\Classs;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassRoutineResource extends JsonResource
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
            'day' => $this->day,
        ];
    }
}
