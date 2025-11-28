// Comprehensive Alert System using SweetAlert2
import Swal from 'sweetalert2';

// Form Validation Alerts
export const formAlerts = {
    // Show validation errors
    showValidationErrors: (errors) => {
        const errorList = Object.entries(errors)
            .map(([field, messages]) => {
                const fieldName = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                return `<li><strong>${fieldName}:</strong> ${Array.isArray(messages) ? messages.join(', ') : messages}</li>`;
            })
            .join('');

        return Swal.fire({
            icon: 'error',
            title: 'Validation Errors',
            html: `<ul class="text-left list-disc list-inside space-y-1">${errorList}</ul>`,
            confirmButtonText: 'Fix Errors',
            confirmButtonColor: '#ef4444',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    },

    // Show field-specific error
    showFieldError: (field, message) => {
        const fieldName = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        return Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: `${fieldName}: ${message}`,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    },

    // Show success message
    showSuccess: (title, message) => {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#10b981',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    }
};

// Cart Alerts
export const cartAlerts = {
    // Add to cart success
    addToCart: (productName) => {
        return Swal.fire({
            icon: 'success',
            title: 'Added to Cart!',
            text: `${productName} has been added to your cart`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Remove from cart confirmation
    removeFromCart: (productName) => {
        return Swal.fire({
            title: 'Remove Item',
            text: `Are you sure you want to remove "${productName}" from your cart?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    },

    // Clear cart confirmation
    clearCart: () => {
        return Swal.fire({
            title: 'Clear Cart',
            text: 'Are you sure you want to remove all items from your cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    }
};

// Wishlist Alerts
export const wishlistAlerts = {
    // Add to wishlist
    addToWishlist: (productName) => {
        return Swal.fire({
            icon: 'success',
            title: 'Added to Wishlist!',
            text: `${productName} has been added to your wishlist`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Already in wishlist
    alreadyInWishlist: (productName) => {
        return Swal.fire({
            icon: 'info',
            title: 'Already in Wishlist',
            text: `${productName} is already in your wishlist`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Remove from wishlist
    removeFromWishlist: (productName) => {
        return Swal.fire({
            title: 'Remove from Wishlist',
            text: `Are you sure you want to remove "${productName}" from your wishlist?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    }
};

// Admin Alerts
export const adminAlerts = {
    // Delete confirmation
    deleteConfirm: (itemName, count = 1) => {
        const title = count > 1 ? 'Delete Selected Items' : 'Delete Item';
        const text = count > 1 
            ? `Are you sure you want to delete ${count} selected item(s)? This action cannot be undone.`
            : `Are you sure you want to delete "${itemName}"? This action cannot be undone.`;

        return Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    },

    // Bulk action confirmation
    bulkActionConfirm: (action, count) => {
        return Swal.fire({
            title: `${action} Selected Items`,
            text: `Are you sure you want to ${action.toLowerCase()} ${count} selected item(s)?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: `Yes, ${action.toLowerCase()} them!`,
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    },

    // Save success
    saveSuccess: (itemName = 'Item') => {
        return Swal.fire({
            icon: 'success',
            title: 'Saved!',
            text: `${itemName} has been saved successfully`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Update success
    updateSuccess: (itemName = 'Item') => {
        return Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: `${itemName} has been updated successfully`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Delete success
    deleteSuccess: (itemName = 'Item', count = 1) => {
        const text = count > 1 
            ? `${count} items have been deleted successfully`
            : `${itemName} has been deleted successfully`;

        return Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: text,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    }
};

// Authentication Alerts
export const authAlerts = {
    // Login success
    loginSuccess: (userName) => {
        return Swal.fire({
            icon: 'success',
            title: 'Welcome back!',
            text: `Hello ${userName}, you have been logged in successfully`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Logout confirmation
    logoutConfirm: () => {
        return Swal.fire({
            title: 'Logout',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, logout!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    },

    // Registration success
    registerSuccess: (userName) => {
        return Swal.fire({
            icon: 'success',
            title: 'Registration Successful!',
            text: `Welcome ${userName}! Your account has been created successfully`,
            confirmButtonText: 'Continue',
            confirmButtonColor: '#10b981',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    }
};

// Newsletter Alerts
export const newsletterAlerts = {
    // Subscribe success
    subscribeSuccess: (email) => {
        return Swal.fire({
            icon: 'success',
            title: 'Subscribed!',
            text: `Thank you! ${email} has been subscribed to our newsletter`,
            showConfirmButton: false,
            timer: 3000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Already subscribed
    alreadySubscribed: (email) => {
        return Swal.fire({
            icon: 'info',
            title: 'Already Subscribed',
            text: `${email} is already subscribed to our newsletter`,
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Unsubscribe confirmation
    unsubscribeConfirm: (email) => {
        return Swal.fire({
            title: 'Unsubscribe',
            text: `Are you sure you want to unsubscribe ${email} from our newsletter?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, unsubscribe!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom',
                cancelButton: 'swal2-cancel-custom'
            }
        });
    }
};

// Error Alerts
export const errorAlerts = {
    // Network error
    networkError: () => {
        return Swal.fire({
            icon: 'error',
            title: 'Network Error',
            text: 'Unable to connect to the server. Please check your internet connection and try again.',
            confirmButtonText: 'Retry',
            confirmButtonColor: '#ef4444',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    },

    // Server error
    serverError: (message = 'An unexpected error occurred. Please try again.') => {
        return Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: message,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    },

    // Permission denied
    permissionDenied: () => {
        return Swal.fire({
            icon: 'error',
            title: 'Access Denied',
            text: 'You do not have permission to perform this action.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444',
            customClass: {
                popup: 'swal2-popup-custom',
                confirmButton: 'swal2-confirm-custom'
            }
        });
    }
};

// Loading Alerts
export const loadingAlerts = {
    // Show loading
    show: (title = 'Loading...', text = 'Please wait') => {
        return Swal.fire({
            title: title,
            text: text,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
            customClass: {
                popup: 'swal2-popup-custom'
            }
        });
    },

    // Close loading
    close: () => {
        Swal.close();
    }
};

// Make all alerts available globally
window.alerts = {
    form: formAlerts,
    cart: cartAlerts,
    wishlist: wishlistAlerts,
    admin: adminAlerts,
    auth: authAlerts,
    newsletter: newsletterAlerts,
    error: errorAlerts,
    loading: loadingAlerts
};

export default {
    formAlerts,
    cartAlerts,
    wishlistAlerts,
    adminAlerts,
    authAlerts,
    newsletterAlerts,
    errorAlerts,
    loadingAlerts
};
