<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sku',
        'barcode',
        'brand_id',
        'category_id',
        'price',
        'cost_price',
        'sale_price',
        'gst_rate',
        'hsn_code',
        'compare_price',
        'discount_type',
        'discount_value',
        'discount_start_at',
        'discount_end_at',
        'stock_quantity',
        'min_stock_level',
        'weight',
        'dimensions',
        'color',
        'size',
        'images',
        'specifications',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'gst_rate' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_start_at' => 'datetime',
        'discount_end_at' => 'datetime',
        'weight' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_quantity <= min_stock_level');
    }

    /**
     * Get the first image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return null;
    }
}