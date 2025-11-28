<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'price' => (float) $this->price,
            'cost_price' => $this->cost_price !== null ? (float) $this->cost_price : null,
            'sale_price' => $this->sale_price !== null ? (float) $this->sale_price : null,
            'compare_price' => $this->compare_price !== null ? (float) $this->compare_price : null,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value !== null ? (float) $this->discount_value : null,
            'discount_start_at' => optional($this->discount_start_at)->toIso8601String(),
            'discount_end_at' => optional($this->discount_end_at)->toIso8601String(),
            'stock_quantity' => (int) $this->stock_quantity,
            'min_stock_level' => (int) $this->min_stock_level,
            'weight' => $this->weight !== null ? (float) $this->weight : null,
            'dimensions' => $this->dimensions,
            'color' => $this->color,
            'size' => $this->size,
            'images' => $this->images ?? [],
            'specifications' => $this->specifications ?? [],
            'seo_title' => $this->seo_title,
            'seo_keywords' => $this->seo_keywords,
            'seo_description' => $this->seo_description,
            'is_active' => (bool) $this->is_active,
            'is_featured' => (bool) $this->is_featured,
            'sort_order' => $this->sort_order,
            'created_at' => optional($this->created_at)->toIso8601String(),
            'updated_at' => optional($this->updated_at)->toIso8601String(),
        ];
    }
}

