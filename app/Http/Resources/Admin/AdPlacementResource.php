<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdPlacementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'position' => $this->position,
            'size' => $this->size,
            'campaign_id' => $this->campaign_id,
            'campaign' => new AdCampaignResource($this->whenLoaded('campaign')),
            'impressions' => $this->impressions,
            'clicks' => $this->clicks,
            'ctr' => $this->ctr !== null ? (float) $this->ctr : null,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}

