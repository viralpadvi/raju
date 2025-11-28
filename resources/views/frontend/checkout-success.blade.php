@extends('layouts.storefront')

@section('title', 'Order Confirmation - ElectroStore')

@section('content')
<div class="container-custom py-8">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-success-100 dark:bg-success-900 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Success Message -->
        <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Order Confirmed!</h1>
        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">Thank you for your purchase. Your order has been successfully placed.</p>

        <!-- Order Details -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-soft p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Order Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Order Information</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Order Number:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-medium">#ORD-2024-001</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Order Date:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ date('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                            <span class="text-gray-900 dark:text-gray-100">Credit Card</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Total Amount:</span>
                            <span class="text-gray-900 dark:text-gray-100 font-semibold">$3,237.84</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Shipping Information</h3>
                    <div class="space-y-2">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Name:</span>
                            <span class="text-gray-900 dark:text-gray-100 ml-2">John Doe</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Address:</span>
                            <span class="text-gray-900 dark:text-gray-100 ml-2">123 Main St, City, State 12345</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                            <span class="text-gray-900 dark:text-gray-100 ml-2">(555) 123-4567</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="text-gray-900 dark:text-gray-100 ml-2">john@example.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-soft p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Ordered Items</h2>
            
            <div class="space-y-4">
                <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <img src="https://via.placeholder.com/80x80/6c757d/ffffff?text=iPhone" alt="iPhone 15 Pro" class="w-20 h-20 rounded-lg object-cover">
                    <div class="flex-1 text-left">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">iPhone 15 Pro</h3>
                        <p class="text-gray-600 dark:text-gray-400">128GB, Space Black</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Quantity: 1</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">$999.00</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <img src="https://via.placeholder.com/80x80/6c757d/ffffff?text=MacBook" alt="MacBook Pro" class="w-20 h-20 rounded-lg object-cover">
                    <div class="flex-1 text-left">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">MacBook Pro</h3>
                        <p class="text-gray-600 dark:text-gray-400">14-inch, M3 Pro, 512GB SSD</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Quantity: 1</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">$1,999.00</p>
                    </div>
                </div>
            </div>

            <!-- Order Total -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                <div class="flex justify-between items-center text-xl font-semibold text-gray-900 dark:text-gray-100">
                    <span>Total:</span>
                    <span>$3,237.84</span>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">What's Next?</h3>
            <div class="text-left space-y-2 text-blue-800 dark:text-blue-200">
                <p>• You will receive an order confirmation email shortly</p>
                <p>• We'll send you tracking information once your order ships</p>
                <p>• Expected delivery: 3-5 business days</p>
                <p>• You can track your order status in your account dashboard</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.orders') }}" class="btn-primary">
                View My Orders
            </a>
            <a href="{{ route('home') }}" class="btn-outline">
                Continue Shopping
            </a>
        </div>

        <!-- Support Information -->
        <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Need help with your order? Contact our support team.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center text-sm">
                <a href="mailto:support@electrostore.com" class="text-primary-600 dark:text-primary-400 hover:underline">
                    support@electrostore.com
                </a>
                <span class="text-gray-400">|</span>
                <a href="tel:+1-555-123-4567" class="text-primary-600 dark:text-primary-400 hover:underline">
                    (555) 123-4567
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Show success message on page load
document.addEventListener('DOMContentLoaded', function() {
    window.utils.showSuccess('Order Placed Successfully!', 'Your order has been confirmed and you will receive an email shortly.');
});
</script>
@endsection
