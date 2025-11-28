{{-- SweetAlert2 Examples Component --}}
{{-- This component demonstrates how to use SweetAlert2 alerts throughout the application --}}

<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-soft">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">SweetAlert2 Examples</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Basic Alerts -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Basic Alerts</h4>
            <button onclick="window.utils.showSuccess('Success!', 'Operation completed successfully')" 
                    class="w-full btn-primary">
                Success Alert
            </button>
            <button onclick="window.utils.showError('Error!', 'Something went wrong')" 
                    class="w-full btn-secondary">
                Error Alert
            </button>
            <button onclick="window.utils.showWarning('Warning!', 'Please be careful')" 
                    class="w-full btn-outline">
                Warning Alert
            </button>
            <button onclick="window.utils.showInfo('Info', 'Here is some information')" 
                    class="w-full btn-outline">
                Info Alert
            </button>
        </div>

        <!-- Confirmation Dialogs -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Confirmations</h4>
            <button onclick="window.utils.showConfirm('Confirm Action', 'Are you sure you want to proceed?')" 
                    class="w-full btn-primary">
                Basic Confirm
            </button>
            <button onclick="window.utils.showDeleteConfirm('Delete Item', 'This action cannot be undone!')" 
                    class="w-full btn-secondary">
                Delete Confirm
            </button>
            <button onclick="window.alerts.cart.clearCart()" 
                    class="w-full btn-outline">
                Clear Cart
            </button>
        </div>

        <!-- Input Dialogs -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Input Dialogs</h4>
            <button onclick="window.utils.showInput('Enter Name', 'Please enter your name:', 'text')" 
                    class="w-full btn-primary">
                Text Input
            </button>
            <button onclick="window.utils.showInput('Enter Email', 'Please enter your email:', 'email')" 
                    class="w-full btn-secondary">
                Email Input
            </button>
            <button onclick="window.utils.showSelect('Choose Option', 'Select an option:', {option1: 'Option 1', option2: 'Option 2'})" 
                    class="w-full btn-outline">
                Select Input
            </button>
        </div>

        <!-- Loading States -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Loading States</h4>
            <button onclick="window.utils.showLoading('Processing...', 'Please wait')" 
                    class="w-full btn-primary">
                Show Loading
            </button>
            <button onclick="window.alerts.loading.show('Saving...', 'Please wait while we save')" 
                    class="w-full btn-secondary">
                Custom Loading
            </button>
            <button onclick="setTimeout(() => window.utils.closeLoading(), 3000)" 
                    class="w-full btn-outline">
                Auto Close (3s)
            </button>
        </div>

        <!-- Toast Notifications -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Toast Notifications</h4>
            <button onclick="window.utils.showToast('Success message!', 'success')" 
                    class="w-full btn-primary">
                Success Toast
            </button>
            <button onclick="window.utils.showToast('Error message!', 'error')" 
                    class="w-full btn-secondary">
                Error Toast
            </button>
            <button onclick="window.utils.showToast('Warning message!', 'warning')" 
                    class="w-full btn-outline">
                Warning Toast
            </button>
            <button onclick="window.utils.showToast('Info message!', 'info')" 
                    class="w-full btn-outline">
                Info Toast
            </button>
        </div>

        <!-- Form Validation -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Form Validation</h4>
            <button onclick="window.alerts.form.showValidationErrors({name: ['Name is required'], email: ['Email is invalid', 'Email is required']})" 
                    class="w-full btn-primary">
                Validation Errors
            </button>
            <button onclick="window.alerts.form.showFieldError('email', 'Please enter a valid email address')" 
                    class="w-full btn-secondary">
                Field Error
            </button>
            <button onclick="window.alerts.form.showSuccess('Form Saved', 'Your form has been saved successfully')" 
                    class="w-full btn-outline">
                Form Success
            </button>
        </div>

        <!-- Cart Operations -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Cart Operations</h4>
            <button onclick="window.alerts.cart.addToCart('iPhone 15 Pro')" 
                    class="w-full btn-primary">
                Add to Cart
            </button>
            <button onclick="window.alerts.cart.removeFromCart('iPhone 15 Pro')" 
                    class="w-full btn-secondary">
                Remove from Cart
            </button>
            <button onclick="window.alerts.cart.clearCart()" 
                    class="w-full btn-outline">
                Clear Cart
            </button>
        </div>

        <!-- Wishlist Operations -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Wishlist Operations</h4>
            <button onclick="window.alerts.wishlist.addToWishlist('MacBook Pro')" 
                    class="w-full btn-primary">
                Add to Wishlist
            </button>
            <button onclick="window.alerts.wishlist.alreadyInWishlist('MacBook Pro')" 
                    class="w-full btn-secondary">
                Already in Wishlist
            </button>
            <button onclick="window.alerts.wishlist.removeFromWishlist('MacBook Pro')" 
                    class="w-full btn-outline">
                Remove from Wishlist
            </button>
        </div>

        <!-- Admin Operations -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Admin Operations</h4>
            <button onclick="window.alerts.admin.deleteConfirm('Product Name', 1)" 
                    class="w-full btn-primary">
                Delete Item
            </button>
            <button onclick="window.alerts.admin.bulkActionConfirm('Delete', 5)" 
                    class="w-full btn-secondary">
                Bulk Delete
            </button>
            <button onclick="window.alerts.admin.saveSuccess('Product')" 
                    class="w-full btn-outline">
                Save Success
            </button>
        </div>

        <!-- Authentication -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Authentication</h4>
            <button onclick="window.alerts.auth.loginSuccess('John Doe')" 
                    class="w-full btn-primary">
                Login Success
            </button>
            <button onclick="window.alerts.auth.logoutConfirm()" 
                    class="w-full btn-secondary">
                Logout Confirm
            </button>
            <button onclick="window.alerts.auth.registerSuccess('Jane Doe')" 
                    class="w-full btn-outline">
                Register Success
            </button>
        </div>

        <!-- Newsletter -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Newsletter</h4>
            <button onclick="window.alerts.newsletter.subscribeSuccess('user@example.com')" 
                    class="w-full btn-primary">
                Subscribe Success
            </button>
            <button onclick="window.alerts.newsletter.alreadySubscribed('user@example.com')" 
                    class="w-full btn-secondary">
                Already Subscribed
            </button>
            <button onclick="window.alerts.newsletter.unsubscribeConfirm('user@example.com')" 
                    class="w-full btn-outline">
                Unsubscribe Confirm
            </button>
        </div>

        <!-- Error Handling -->
        <div class="space-y-2">
            <h4 class="font-medium text-gray-700 dark:text-gray-300">Error Handling</h4>
            <button onclick="window.alerts.error.networkError()" 
                    class="w-full btn-primary">
                Network Error
            </button>
            <button onclick="window.alerts.error.serverError('Database connection failed')" 
                    class="w-full btn-secondary">
                Server Error
            </button>
            <button onclick="window.alerts.error.permissionDenied()" 
                    class="w-full btn-outline">
                Permission Denied
            </button>
        </div>
    </div>
</div>

{{-- Usage Examples in Alpine.js Components --}}
<script>
// Example of using alerts in Alpine.js components
document.addEventListener('alpine:init', () => {
    Alpine.data('exampleComponent', () => ({
        async deleteItem(itemId) {
            const result = await window.alerts.admin.deleteConfirm('Item', 1);
            if (result.isConfirmed) {
                // Perform delete operation
                try {
                    // API call here
                    await window.alerts.admin.deleteSuccess('Item');
                } catch (error) {
                    await window.alerts.error.serverError('Failed to delete item');
                }
            }
        },

        async saveForm() {
            window.alerts.loading.show('Saving...', 'Please wait');
            try {
                // Form submission logic
                await new Promise(resolve => setTimeout(resolve, 2000)); // Simulate API call
                window.alerts.loading.close();
                await window.alerts.admin.saveSuccess('Form');
            } catch (error) {
                window.alerts.loading.close();
                await window.alerts.error.serverError('Failed to save form');
            }
        }
    }));
});
</script>
