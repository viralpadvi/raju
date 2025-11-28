<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::where('is_active', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('details', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by tags
        if ($request->has('tag') && $request->tag) {
            $query->whereJsonContains('tags', $request->tag);
        }

        // Get unique categories for filter
        $categories = Project::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        // Get unique tags for filter
        $allTags = Project::where('is_active', true)
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->values();

        // Sort by featured first, then by sort_order, then by created_at
        $projects = $query->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('frontend.projects.index', compact('projects', 'categories', 'allTags'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related projects (same category, excluding current)
        $relatedProjects = Project::where('is_active', true)
            ->where('id', '!=', $project->id)
            ->where(function ($query) use ($project) {
                if ($project->category) {
                    $query->where('category', $project->category);
                }
                if ($project->tags && count($project->tags) > 0) {
                    foreach ($project->tags as $tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    }
                }
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        // If not enough related projects, get latest featured projects
        if ($relatedProjects->count() < 4) {
            $additionalProjects = Project::where('is_active', true)
                ->where('id', '!=', $project->id)
                ->whereNotIn('id', $relatedProjects->pluck('id'))
                ->orderByDesc('is_featured')
                ->orderByDesc('created_at')
                ->take(4 - $relatedProjects->count())
                ->get();
            
            $relatedProjects = $relatedProjects->merge($additionalProjects);
        }

        return view('frontend.projects.show', compact('project', 'relatedProjects'));
    }
}

