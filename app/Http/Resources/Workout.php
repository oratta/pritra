<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Workout extends JsonResource
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
            "repCount" => $this->rep_count,
            'difficultyType' => $this->difficultyType,
        ];
    }
}
