<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Workout as WorkoutResource;

class WorkoutSet extends JsonResource
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
            'step' => ['name' => $this->step->getViewName()],
            'menu' => ['name' => $this->menu->name],
            'plannedMinRepCount' => $this->planned_min_rep_count,
            'plannedSetCount' => $this->planned_set_count,
            'setCount' => $this->set_count,
            'repCount' => $this->min_rep_count,
            'workoutList' => WorkoutResource::collection($this->workouts),
            'date' => $this->end_time,
        ];
    }
}
