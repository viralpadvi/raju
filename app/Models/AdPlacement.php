<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPlacement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'position',
        'size',
        'campaign_id',
        'impressions',
        'clicks',
        'ctr',
        'status',
    ];

    protected $casts = [
        'ctr' => 'decimal:2',
    ];

    public function campaign()
    {
        return $this->belongsTo(AdCampaign::class, 'campaign_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }
}