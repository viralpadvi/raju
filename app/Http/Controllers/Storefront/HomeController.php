<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Project;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['brand', 'category'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderByDesc('id')
            ->take(8)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['brand', 'category'])
                ->where('is_active', true)
                ->orderByDesc('id')
                ->take(8)
                ->get();
        }

        $topCategories = Category::withCount('products')
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(4)
            ->get();

        $topBrands = Brand::withCount('products')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(6)
            ->get();

        // Get featured projects
        $featuredProjects = Project::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // If not enough featured projects, get latest active projects
        if ($featuredProjects->count() < 6) {
            $additionalProjects = Project::where('is_active', true)
                ->whereNotIn('id', $featuredProjects->pluck('id'))
                ->orderByDesc('created_at')
                ->take(6 - $featuredProjects->count())
                ->get();
            
            $featuredProjects = $featuredProjects->merge($additionalProjects);
        }

        return view('frontend.home', [
            'featuredProducts' => $featuredProducts,
            'topCategories' => $topCategories,
            'topBrands' => $topBrands,
            'featuredProjects' => $featuredProjects,
        ]);
    }
}


