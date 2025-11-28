<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdPlacementResource;
use App\Models\AdPlacement;
use Illuminate\Http\Request;

class AdPlacementController extends Controller
{
    public function index(Request $request)
    {
        $query = AdPlacement::with('campaign');

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('campaign_id')) {
            $query->where('campaign_id', $request->integer('campaign_id'));
        }

        $placements = $query->latest()->paginate($request->integer('per_page', 15));

        return AdPlacementResource::collection($placements);
    }

    public function store(Request $request): AdPlacementResource
    {
        $validated = $this->validatedData($request);
        $placement = AdPlacement::create($validated);

        return new AdPlacementResource($placement->load('campaign'));
    }

    public function show(AdPlacement $placement): AdPlacementResource
    {
        return new AdPlacementResource($placement->load('campaign'));
    }

    public function update(Request $request, AdPlacement $placement): AdPlacementResource
    {
        $validated = $this->validatedData($request);
        $placement->update($validated);

        return new AdPlacementResource($placement->load('campaign'));
    }

    public function destroy(AdPlacement $placement)
    {
        $placement->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Placement deleted successfully.',
        ]);
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:100'],
            'size' => ['nullable', 'string', 'max:100'],
            'campaign_id' => ['nullable', 'exists:ad_campaigns,id'],
            'impressions' => ['nullable', 'integer', 'min:0'],
            'clicks' => ['nullable', 'integer', 'min:0'],
            'ctr' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,scheduled,active,paused,completed'],
        ]);
    }
}

