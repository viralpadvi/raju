# SweetAlert2 Usage Guide

This application uses SweetAlert2 for all alerts, confirmations, and notifications. The system is designed to be consistent, accessible, and easy to use throughout the application.

## Quick Start

All SweetAlert2 functions are available globally through `window.utils` and `window.alerts` objects.

### Basic Usage

```javascript
// Success alert
await window.utils.showSuccess('Success!', 'Operation completed successfully');

// Error alert
await window.utils.showError('Error!', 'Something went wrong');

// Warning alert
await window.utils.showWarning('Warning!', 'Please be careful');

// Info alert
await window.utils.showInfo('Info', 'Here is some information');

// Toast notification
window.utils.showToast('Item added to cart!', 'success');

// Confirmation dialog
const result = await window.utils.showConfirm('Confirm Action', 'Are you sure?');
if (result.isConfirmed) {
    // User clicked "Yes"
}

// Delete confirmation
const result = await window.utils.showDeleteConfirm('Delete Item', 'This cannot be undone!');
if (result.isConfirmed) {
    // User confirmed deletion
}
```

## Available Alert Types

### 1. Basic Alerts (`window.utils`)

- `showSuccess(title, text, options)` - Success alert
- `showError(title, text, options)` - Error alert
- `showWarning(title, text, options)` - Warning alert
- `showInfo(title, text, options)` - Info alert
- `showConfirm(title, text, options)` - Confirmation dialog
- `showDeleteConfirm(title, text, options)` - Delete confirmation
- `showToast(message, type, duration)` - Toast notification
- `showLoading(title, text)` - Loading alert
- `closeLoading()` - Close loading alert
- `showInput(title, text, inputType, options)` - Input dialog
- `showSelect(title, text, options, optionsConfig)` - Select dialog
- `showForm(title, html, options)` - Form dialog

### 2. Specialized Alerts (`window.alerts`)

#### Form Alerts (`window.alerts.form`)
- `showValidationErrors(errors)` - Show form validation errors
- `showFieldError(field, message)` - Show field-specific error
- `showSuccess(title, message)` - Form success message

#### Cart Alerts (`window.alerts.cart`)
- `addToCart(productName)` - Add to cart success
- `removeFromCart(productName)` - Remove from cart confirmation
- `clearCart()` - Clear cart confirmation

#### Wishlist Alerts (`window.alerts.wishlist`)
- `addToWishlist(productName)` - Add to wishlist success
- `alreadyInWishlist(productName)` - Already in wishlist info
- `removeFromWishlist(productName)` - Remove from wishlist confirmation

#### Admin Alerts (`window.alerts.admin`)
- `deleteConfirm(itemName, count)` - Delete confirmation
- `bulkActionConfirm(action, count)` - Bulk action confirmation
- `saveSuccess(itemName)` - Save success
- `updateSuccess(itemName)` - Update success
- `deleteSuccess(itemName, count)` - Delete success

#### Authentication Alerts (`window.alerts.auth`)
- `loginSuccess(userName)` - Login success
- `logoutConfirm()` - Logout confirmation
- `registerSuccess(userName)` - Registration success

#### Newsletter Alerts (`window.alerts.newsletter`)
- `subscribeSuccess(email)` - Subscribe success
- `alreadySubscribed(email)` - Already subscribed info
- `unsubscribeConfirm(email)` - Unsubscribe confirmation

#### Error Alerts (`window.alerts.error`)
- `networkError()` - Network error
- `serverError(message)` - Server error
- `permissionDenied()` - Permission denied

#### Loading Alerts (`window.alerts.loading`)
- `show(title, text)` - Show loading
- `close()` - Close loading

## Usage Examples

### 1. Form Validation

```javascript
// Show validation errors
const errors = {
    name: ['Name is required'],
    email: ['Email is invalid', 'Email is required']
};
await window.alerts.form.showValidationErrors(errors);

// Show field-specific error
await window.alerts.form.showFieldError('email', 'Please enter a valid email address');

// Show form success
await window.alerts.form.showSuccess('Form Saved', 'Your form has been saved successfully');
```

### 2. Cart Operations

```javascript
// Add item to cart
await window.alerts.cart.addToCart('iPhone 15 Pro');

// Remove item from cart
const result = await window.alerts.cart.removeFromCart('iPhone 15 Pro');
if (result.isConfirmed) {
    // Remove item logic
}

// Clear cart
const result = await window.alerts.cart.clearCart();
if (result.isConfirmed) {
    // Clear cart logic
}
```

### 3. Admin Operations

```javascript
// Delete single item
const result = await window.alerts.admin.deleteConfirm('Product Name', 1);
if (result.isConfirmed) {
    // Delete logic
}

// Bulk delete
const result = await window.alerts.admin.bulkActionConfirm('Delete', 5);
if (result.isConfirmed) {
    // Bulk delete logic
}

// Show success messages
await window.alerts.admin.saveSuccess('Product');
await window.alerts.admin.updateSuccess('Product');
await window.alerts.admin.deleteSuccess('Product', 1);
```

### 4. Authentication

```javascript
// Login success
await window.alerts.auth.loginSuccess('John Doe');

// Logout confirmation
const result = await window.alerts.auth.logoutConfirm();
if (result.isConfirmed) {
    // Logout logic
}

// Registration success
await window.alerts.auth.registerSuccess('Jane Doe');
```

### 5. Newsletter

```javascript
// Subscribe success
await window.alerts.newsletter.subscribeSuccess('user@example.com');

// Already subscribed
await window.alerts.newsletter.alreadySubscribed('user@example.com');

// Unsubscribe confirmation
const result = await window.alerts.newsletter.unsubscribeConfirm('user@example.com');
if (result.isConfirmed) {
    // Unsubscribe logic
}
```

### 6. Error Handling

```javascript
try {
    // API call
    const response = await fetch('/api/data');
    if (!response.ok) {
        throw new Error('API Error');
    }
} catch (error) {
    if (error.name === 'TypeError') {
        await window.alerts.error.networkError();
    } else {
        await window.alerts.error.serverError(error.message);
    }
}
```

### 7. Loading States

```javascript
// Show loading
window.alerts.loading.show('Saving...', 'Please wait while we save your changes');

try {
    // API call
    await saveData();
    window.alerts.loading.close();
    await window.alerts.admin.saveSuccess('Data');
} catch (error) {
    window.alerts.loading.close();
    await window.alerts.error.serverError('Failed to save data');
}
```

## Alpine.js Integration

### In Alpine.js Components

```javascript
Alpine.data('myComponent', () => ({
    async deleteItem(itemId) {
        const result = await window.alerts.admin.deleteConfirm('Item', 1);
        if (result.isConfirmed) {
            try {
                // API call
                await this.performDelete(itemId);
                await window.alerts.admin.deleteSuccess('Item');
            } catch (error) {
                await window.alerts.error.serverError('Failed to delete item');
            }
        }
    },

    async saveForm() {
        window.alerts.loading.show('Saving...', 'Please wait');
        try {
            await this.submitForm();
            window.alerts.loading.close();
            await window.alerts.admin.saveSuccess('Form');
        } catch (error) {
            window.alerts.loading.close();
            await window.alerts.error.serverError('Failed to save form');
        }
    }
}));
```

### In Blade Templates

```html
<button onclick="window.utils.showSuccess('Success!', 'Operation completed')">
    Show Success
</button>

<button onclick="window.alerts.cart.addToCart('Product Name')">
    Add to Cart
</button>

<button onclick="window.alerts.admin.deleteConfirm('Item', 1)">
    Delete Item
</button>
```

## Customization

### Custom Styling

The alerts use custom CSS classes that can be modified in `resources/css/app.css`:

```css
.swal2-popup-custom {
    @apply font-sans rounded-xl border border-gray-200 dark:border-gray-700;
}

.swal2-confirm-custom {
    @apply px-6 py-2 rounded-lg font-medium transition-all duration-200 hover:shadow-md;
}

.swal2-cancel-custom {
    @apply px-6 py-2 rounded-lg font-medium transition-all duration-200 hover:shadow-md;
}
```

### Dark Mode Support

All alerts automatically support dark mode through the `dark` class on the HTML element.

### Custom Options

You can pass custom options to any alert function:

```javascript
await window.utils.showSuccess('Success!', 'Operation completed', {
    timer: 5000,
    showConfirmButton: false,
    customClass: {
        popup: 'my-custom-popup'
    }
});
```

## Best Practices

1. **Use appropriate alert types**: Use success for positive actions, error for failures, warning for caution, info for information.

2. **Provide clear messages**: Make sure your alert messages are clear and actionable.

3. **Use confirmations for destructive actions**: Always ask for confirmation before deleting or making irreversible changes.

4. **Show loading states**: Use loading alerts for operations that take time.

5. **Handle errors gracefully**: Always catch and display errors appropriately.

6. **Use toast notifications for non-critical messages**: Use toasts for success messages that don't require user interaction.

7. **Consistent styling**: Use the predefined alert functions to maintain consistent styling throughout the application.

## Migration from Standard Alerts

Replace standard JavaScript alerts:

```javascript
// Old way
alert('Hello World');
confirm('Are you sure?');

// New way
window.utils.showInfo('Hello World');
window.utils.showConfirm('Are you sure?');
```

Replace Laravel session flash messages:

```php
// In Controller
return redirect()->back()->with('success', 'Item saved successfully');

// In Blade template
@if(session('success'))
    <script>
        window.utils.showToast('{{ session('success') }}', 'success');
    </script>
@endif
```

This comprehensive alert system ensures a consistent and professional user experience throughout your application.
