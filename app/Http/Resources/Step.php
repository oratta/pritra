<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Step extends JsonResource
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
            'name'  => $this->getViewName(),
            'id'    => $this->id,
            'levelInfo' => $this->getLevelInfo(),
        ];
    }
}
