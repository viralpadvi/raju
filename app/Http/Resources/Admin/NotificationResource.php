<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'order_id' => $this->order_id,
            'order_number' => $this->order_number,
            'is_read' => $this->is_read,
            'read_at' => optional($this->read_at)->toIso8601String(),
            'data' => $this->data,
            'created_at' => optional($this->created_at)->toIso8601String(),
        ];
    }
}

