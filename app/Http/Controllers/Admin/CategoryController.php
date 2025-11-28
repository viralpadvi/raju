<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query()->with(['parent', 'children'])->withCount('products');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by parent category
        if ($request->has('parent_id') && $request->parent_id !== '') {
            $query->where('parent_id', $request->parent_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }

        $categories = $query->orderBy('sort_order')
                           ->orderBy('name')
                           ->paginate(15);

        // Get parent categories for filter dropdown
        $parentCategories = Category::whereNull('parent_id')
                                  ->where('is_active', true)
                                  ->orderBy('name')
                                  ->get();

        return view('admin.catalog.categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')
                                  ->where('is_active', true)
                                  ->orderBy('name')
                                  ->get();
        
        return view('admin.catalog.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/categories', $imageName);
            $data['image'] = 'categories/' . $imageName;
        }

        Category::create($data);

        return redirect()->route('admin.catalog.categories.index')
                        ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'products']);
        return view('admin.catalog.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
                                  ->where('is_active', true)
                                  ->where('id', '!=', $category->id)
                                  ->orderBy('name')
                                  ->get();
        
        return view('admin.catalog.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && \Storage::exists('public/' . $category->image)) {
                \Storage::delete('public/' . $category->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/categories', $imageName);
            $data['image'] = 'categories/' . $imageName;
        }

        $category->update($data);

        return redirect()->route('admin.catalog.categories.index')
                        ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.catalog.categories.index')
                            ->with('error', 'Cannot delete category with associated products.');
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.catalog.categories.index')
                            ->with('error', 'Cannot delete category with subcategories.');
        }

        // Delete image if exists
        if ($category->image && \Storage::exists('public/' . $category->image)) {
            \Storage::delete('public/' . $category->image);
        }

        $category->delete();

        return redirect()->route('admin.catalog.categories.index')
                        ->with('success', 'Category deleted successfully.');
    }
}
