<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request): array
    {
        $value = $this->value;

        if ($this->type === 'json' && is_string($value)) {
            $value = json_decode($value, true);
        }

        return [
            'key' => $this->key,
            'value' => $value,
            'type' => $this->type,
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}

