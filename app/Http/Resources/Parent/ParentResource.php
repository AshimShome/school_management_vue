<?php

namespace App\Http\Resources\Parent;

use Illuminate\Http\Resources\Json\JsonResource;

class ParentResource extends JsonResource
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
            'id'                        =>  $this->id,
            'user_id'                   =>  $this->user_id,
            'phone'                     =>  $this->phone,
            'gender'                    =>  $this->gender,
            'occupation'                    =>  $this->occupation,
            'user'                      =>  $this->whenLoaded('user', function () {
                return $this->user;
            }),
            'created_at'                =>  $this->created_at,
        ];
    }
}
