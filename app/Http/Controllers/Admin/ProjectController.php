<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:manage-projects');
    // }

    public function index(Request $request)
    {
        $query = Project::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('client', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by active status
        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('is_active', $request->is_active === '1');
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured !== '') {
            $query->where('is_featured', $request->is_featured === '1');
        }

        $projects = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);

        // Get unique categories for filter
        $categories = Project::distinct()->whereNotNull('category')->pluck('category');

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'client' => 'nullable|string|max:255',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'specification' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'videos.*' => 'nullable|mimes:mp4,avi,mov,wmv,flv|max:51200',
            'youtube_link' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',
            'github_link' => 'nullable|url|max:255',
            'website_link' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed,on_hold,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'budget' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $data = $validated;
        $data['slug'] = $data['slug'] ?? Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Parse tags from comma-separated string to array
        if ($request->filled('tags')) {
            if (is_string($request->tags)) {
                $data['tags'] = array_filter(array_map('trim', explode(',', $request->tags)));
            }
        } else {
            $data['tags'] = [];
        }

        // Handle client logo upload
        if ($request->hasFile('client_logo')) {
            $data['client_logo'] = $request->file('client_logo')->store('projects/clients', 'public');
        }

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('projects/images', 'public');
            }
            $data['images'] = $images;
        }

        // Handle multiple video uploads
        if ($request->hasFile('videos')) {
            $videos = [];
            foreach ($request->file('videos') as $video) {
                $videos[] = $video->store('projects/videos', 'public');
            }
            $data['videos'] = $videos;
        }

        $project = Project::create($data);

        return redirect()->route('admin.projects.show', $project)
                        ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,' . $project->id,
            'client' => 'nullable|string|max:255',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'client_website' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'specification' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'videos.*' => 'nullable|mimes:mp4,avi,mov,wmv,flv|max:51200',
            'youtube_link' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',
            'github_link' => 'nullable|url|max:255',
            'website_link' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed,on_hold,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'budget' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $data = $validated;
        $data['slug'] = $data['slug'] ?? Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Parse tags from comma-separated string to array
        if ($request->filled('tags')) {
            if (is_string($request->tags)) {
                $data['tags'] = array_filter(array_map('trim', explode(',', $request->tags)));
            }
        } else {
            $data['tags'] = [];
        }

        // Handle client logo upload
        if ($request->hasFile('client_logo')) {
            // Delete old logo if exists
            if ($project->client_logo && Storage::disk('public')->exists($project->client_logo)) {
                Storage::disk('public')->delete($project->client_logo);
            }
            $data['client_logo'] = $request->file('client_logo')->store('projects/clients', 'public');
        }

        // Handle multiple image uploads
        $existingImages = $request->get('existing_images', []);
        // Delete removed images
        if ($project->images) {
            foreach ($project->images as $image) {
                if (!in_array($image, $existingImages) && Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        
        $newImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newImages[] = $image->store('projects/images', 'public');
            }
        }
        
        $data['images'] = array_merge($existingImages, $newImages);

        // Handle multiple video uploads
        $existingVideos = $request->get('existing_videos', []);
        // Delete removed videos
        if ($project->videos) {
            foreach ($project->videos as $video) {
                if (!in_array($video, $existingVideos) && Storage::disk('public')->exists($video)) {
                    Storage::disk('public')->delete($video);
                }
            }
        }
        
        $newVideos = [];
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $newVideos[] = $video->store('projects/videos', 'public');
            }
        }
        
        $data['videos'] = array_merge($existingVideos, $newVideos);

        $project->update($data);

        return redirect()->route('admin.projects.show', $project)
                        ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Delete associated files
        if ($project->client_logo && Storage::disk('public')->exists($project->client_logo)) {
            Storage::disk('public')->delete($project->client_logo);
        }

        if ($project->images) {
            foreach ($project->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        if ($project->videos) {
            foreach ($project->videos as $video) {
                if (Storage::disk('public')->exists($video)) {
                    Storage::disk('public')->delete($video);
                }
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
                        ->with('success', 'Project deleted successfully.');
    }

    public function toggleStatus(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);
        
        $status = $project->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.projects.index')
                        ->with('success', "Project {$status} successfully.");
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);
        
        $status = $project->is_featured ? 'featured' : 'unfeatured';
        return redirect()->route('admin.projects.index')
                        ->with('success', "Project {$status} successfully.");
    }
}

