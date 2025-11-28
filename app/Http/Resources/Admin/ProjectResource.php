<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'client' => $this->client,
            'client_logo' => $this->client_logo ? asset('storage/' . $this->client_logo) : null,
            'client_website' => $this->client_website,
            'description' => $this->description,
            'details' => $this->details,
            'specification' => $this->specification ?? [],
            'images' => $this->images ? array_map(function ($image) {
                return asset('storage/' . $image);
            }, $this->images) : [],
            'videos' => $this->videos ? array_map(function ($video) {
                return asset('storage/' . $video);
            }, $this->videos) : [],
            'youtube_link' => $this->youtube_link,
            'facebook_link' => $this->facebook_link,
            'twitter_link' => $this->twitter_link,
            'instagram_link' => $this->instagram_link,
            'linkedin_link' => $this->linkedin_link,
            'github_link' => $this->github_link,
            'website_link' => $this->website_link,
            'start_date' => optional($this->start_date)->format('Y-m-d'),
            'end_date' => optional($this->end_date)->format('Y-m-d'),
            'status' => $this->status,
            'priority' => $this->priority,
            'budget' => $this->budget ? (float) $this->budget : null,
            'category' => $this->category,
            'tags' => $this->tags ?? [],
            'is_featured' => (bool) $this->is_featured,
            'is_active' => (bool) $this->is_active,
            'sort_order' => $this->sort_order,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}

