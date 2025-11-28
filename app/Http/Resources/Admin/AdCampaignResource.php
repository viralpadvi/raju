<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdCampaignResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'budget' => (float) $this->budget,
            'daily_budget' => $this->daily_budget !== null ? (float) $this->daily_budget : null,
            'spent' => $this->spent !== null ? (float) $this->spent : null,
            'start_date' => optional($this->start_date)->toDateString(),
            'end_date' => optional($this->end_date)->toDateString(),
            'status' => $this->status,
            'target_audience' => $this->target_audience,
            'targeting_options' => $this->targeting_options ?? [],
            'placements' => AdPlacementResource::collection($this->whenLoaded('placements')),
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}

