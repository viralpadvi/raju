<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdCampaignResource;
use App\Models\AdCampaign;
use Illuminate\Http\Request;

class AdCampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = AdCampaign::query();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $campaigns = $query->latest()->paginate($request->integer('per_page', 15));

        return AdCampaignResource::collection($campaigns);
    }

    public function store(Request $request): AdCampaignResource
    {
        $validated = $this->validatedData($request);
        $campaign = AdCampaign::create($validated);

        return new AdCampaignResource($campaign);
    }

    public function show(AdCampaign $campaign): AdCampaignResource
    {
        return new AdCampaignResource($campaign->load('placements'));
    }

    public function update(Request $request, AdCampaign $campaign): AdCampaignResource
    {
        $validated = $this->validatedData($request);
        $campaign->update($validated);

        return new AdCampaignResource($campaign->load('placements'));
    }

    public function destroy(AdCampaign $campaign)
    {
        if ($campaign->placements()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Remove placements before deleting a campaign.',
            ], 422);
        }

        $campaign->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign deleted successfully.',
        ]);
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'max:100'],
            'budget' => ['required', 'numeric', 'min:0'],
            'daily_budget' => ['nullable', 'numeric', 'min:0'],
            'spent' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:draft,scheduled,active,paused,completed,archived'],
            'target_audience' => ['nullable', 'string'],
            'targeting_options' => ['nullable', 'array'],
        ]);
    }
}

