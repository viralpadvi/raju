@extends('layouts.storefront')

@section('title', 'Compare Products - ElectroStore')

@section('content')
<div class="container-custom py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-primary-500 transition-colors duration-200">Home</a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 dark:text-gray-100">Compare Products</span>
        </nav>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Compare Products</h1>

        <!-- Compare Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-soft overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Features</th>
                            <th class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                <div class="flex flex-col items-center">
                                    <img src="https://via.placeholder.com/120x120/6c757d/ffffff?text=iPhone+15+Pro" alt="iPhone 15 Pro" class="w-20 h-20 rounded-lg mb-2">
                                    <h3 class="font-semibold">iPhone 15 Pro</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">$999.00</p>
                                    <button onclick="removeFromCompare(1)" class="mt-2 text-red-600 hover:text-red-800 text-sm">Remove</button>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                <div class="flex flex-col items-center">
                                    <img src="https://via.placeholder.com/120x120/6c757d/ffffff?text=iPhone+15" alt="iPhone 15" class="w-20 h-20 rounded-lg mb-2">
                                    <h3 class="font-semibold">iPhone 15</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">$799.00</p>
                                    <button onclick="removeFromCompare(2)" class="mt-2 text-red-600 hover:text-red-800 text-sm">Remove</button>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                <div class="flex flex-col items-center">
                                    <img src="https://via.placeholder.com/120x120/6c757d/ffffff?text=iPhone+14+Pro" alt="iPhone 14 Pro" class="w-20 h-20 rounded-lg mb-2">
                                    <h3 class="font-semibold">iPhone 14 Pro</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">$899.00</p>
                                    <button onclick="removeFromCompare(3)" class="mt-2 text-red-600 hover:text-red-800 text-sm">Remove</button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Display</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">6.1" Super Retina XDR</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">6.1" Super Retina XDR</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">6.1" Super Retina XDR</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Processor</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">A17 Pro</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">A16 Bionic</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">A16 Bionic</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Storage</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">128GB, 256GB, 512GB, 1TB</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">128GB, 256GB, 512GB</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">128GB, 256GB, 512GB, 1TB</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Camera</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">48MP Main, 12MP Ultra Wide, 12MP Telephoto</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">48MP Main, 12MP Ultra Wide</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">48MP Main, 12MP Ultra Wide, 12MP Telephoto</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Battery Life</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">Up to 23 hours video playback</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">Up to 20 hours video playback</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">Up to 23 hours video playback</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Water Resistance</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">IP68 (6m for 30 min)</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">IP68 (6m for 30 min)</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">IP68 (6m for 30 min)</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Colors</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">Natural Titanium, Blue Titanium, White Titanium, Black Titanium</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">Pink, Yellow, Green, Blue, Black</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">Deep Purple, Gold, Silver, Space Black</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">Actions</td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="addToCart(1)" class="btn-primary text-sm py-2 px-4">Add to Cart</button>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="addToCart(2)" class="btn-primary text-sm py-2 px-4">Add to Cart</button>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="addToCart(3)" class="btn-primary text-sm py-2 px-4">Add to Cart</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State -->
        <div id="emptyCompare" class="hidden text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No products to compare</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Add products to compare their features and specifications</p>
            <a href="{{ route('products') }}" class="btn-primary">Browse Products</a>
        </div>

        <!-- Add More Products -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-4">Want to compare more products?</p>
            <a href="{{ route('products') }}" class="btn-outline">Add More Products</a>
        </div>
    </div>
</div>

<script>
function removeFromCompare(productId) {
    // Simulate removing product from comparison
    window.utils.showToast('Product removed from comparison', 'info');
    
    // In a real app, you would update the comparison state
    // and re-render the table
}

function addToCart(productId) {
    window.utils.showToast('Product added to cart!', 'success');
}
</script>
@endsection
