<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        $perPage = $request->integer('per_page', 15);
        $projects = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate($perPage);

        return ProjectResource::collection($projects);
    }

    public function store(Request $request): ProjectResource
    {
        $validated = $this->validatedData($request);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects/images', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            $videos = [];
            foreach ($request->file('videos') as $video) {
                $path = $video->store('projects/videos', 'public');
                $videos[] = $path;
            }
            $validated['videos'] = $videos;
        }

        // Handle client logo upload
        if ($request->hasFile('client_logo')) {
            $validated['client_logo'] = $request->file('client_logo')->store('projects/clients', 'public');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $project = Project::create($validated);

        return new ProjectResource($project);
    }

    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project): ProjectResource
    {
        $validated = $this->validatedData($request, $project->id);

        // Handle image uploads
        if ($request->hasFile('images')) {
            // Delete old images
            if ($project->images) {
                foreach ($project->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('projects/images', 'public');
                $images[] = $path;
            }
            $validated['images'] = $images;
        } elseif ($request->has('images')) {
            // Keep existing images if provided as array
            $validated['images'] = $request->get('images');
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            // Delete old videos
            if ($project->videos) {
                foreach ($project->videos as $oldVideo) {
                    Storage::disk('public')->delete($oldVideo);
                }
            }

            $videos = [];
            foreach ($request->file('videos') as $video) {
                $path = $video->store('projects/videos', 'public');
                $videos[] = $path;
            }
            $validated['videos'] = $videos;
        } elseif ($request->has('videos')) {
            $validated['videos'] = $request->get('videos');
        }

        // Handle client logo upload
        if ($request->hasFile('client_logo')) {
            if ($project->client_logo) {
                Storage::disk('public')->delete($project->client_logo);
            }
            $validated['client_logo'] = $request->file('client_logo')->store('projects/clients', 'public');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $project->update($validated);

        return new ProjectResource($project->fresh());
    }

    public function destroy(Project $project)
    {
        // Delete associated files
        if ($project->images) {
            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        if ($project->videos) {
            foreach ($project->videos as $video) {
                Storage::disk('public')->delete($video);
            }
        }

        if ($project->client_logo) {
            Storage::disk('public')->delete($project->client_logo);
        }

        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully.',
        ]);
    }

    private function validatedData(Request $request, ?int $projectId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'client' => ['nullable', 'string', 'max:255'],
            'client_logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'client_website' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'specification' => ['nullable', 'array'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'videos' => ['nullable', 'array'],
            'videos.*' => ['nullable', 'mimes:mp4,avi,mov,wmv,flv', 'max:51200'],
            'youtube_link' => ['nullable', 'url', 'max:255'],
            'facebook_link' => ['nullable', 'url', 'max:255'],
            'twitter_link' => ['nullable', 'url', 'max:255'],
            'instagram_link' => ['nullable', 'url', 'max:255'],
            'linkedin_link' => ['nullable', 'url', 'max:255'],
            'github_link' => ['nullable', 'url', 'max:255'],
            'website_link' => ['nullable', 'url', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:pending,in_progress,completed,on_hold,cancelled'],
            'priority' => ['nullable', 'in:low,medium,high,urgent'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
        ]);
    }
}

