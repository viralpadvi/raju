import './bootstrap';
import Alpine from 'alpinejs';

// Storefront specific Alpine.js components
Alpine.data('cart', () => ({
    items: [],
    total: 0,
    count: 0,
    isOpen: false,
    
    init() {
        this.loadCart();
        this.updateCartDisplay();
    },
    
    loadCart() {
        const saved = localStorage.getItem('cart');
        if (saved) {
            this.items = JSON.parse(saved);
            this.calculateTotal();
        }
    },
    
    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.items));
    },
    
    addItem(product) {
        const existingItem = this.items.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }
        
        this.calculateTotal();
        this.saveCart();
        this.updateCartDisplay();
        this.showToast('Item added to cart!', 'success');
    },
    
    async removeItem(id) {
        const result = await window.utils.showDeleteConfirm(
            'Remove Item',
            'Are you sure you want to remove this item from your cart?'
        );
        
        if (result.isConfirmed) {
            this.items = this.items.filter(item => item.id !== id);
            this.calculateTotal();
            this.saveCart();
            this.updateCartDisplay();
            this.showToast('Item removed from cart', 'info');
        }
    },
    
    updateQuantity(id, quantity) {
        const item = this.items.find(item => item.id === id);
        if (item) {
            if (quantity <= 0) {
                this.removeItem(id);
            } else {
                item.quantity = quantity;
                this.calculateTotal();
                this.saveCart();
                this.updateCartDisplay();
            }
        }
    },
    
    calculateTotal() {
        this.total = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        this.count = this.items.reduce((sum, item) => sum + item.quantity, 0);
    },
    
    updateCartDisplay() {
        const countElement = document.getElementById('cart-count');
        if (countElement) {
            countElement.textContent = this.count;
            countElement.classList.toggle('hidden', this.count === 0);
        }
    },
    
    toggleCart() {
        this.isOpen = !this.isOpen;
    },
    
    async clearCart() {
        const result = await window.utils.showDeleteConfirm(
            'Clear Cart',
            'Are you sure you want to remove all items from your cart?'
        );
        
        if (result.isConfirmed) {
            this.items = [];
            this.calculateTotal();
            this.saveCart();
            this.updateCartDisplay();
            this.showToast('Cart cleared', 'info');
        }
    },
    
    showToast(message, type = 'info') {
        if (window.utils) {
            window.utils.showToast(message, type);
        }
    }
}));

Alpine.data('search', () => ({
    query: '',
    results: [],
    isSearching: false,
    showResults: false,
    
    init() {
        this.debouncedSearch = this.debounce(this.performSearch.bind(this), 300);
    },
    
    performSearch() {
        if (this.query.length < 2) {
            this.results = [];
            this.showResults = false;
            return;
        }
        
        this.isSearching = true;
        
        // Simulate API call - replace with actual implementation
        fetch(`/api/search?q=${encodeURIComponent(this.query)}`)
            .then(response => response.json())
            .then(data => {
                this.results = data.results || [];
                this.showResults = true;
                this.isSearching = false;
            })
            .catch(error => {
                console.error('Search error:', error);
                this.isSearching = false;
            });
    },
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    selectResult(result) {
        this.query = result.name;
        this.showResults = false;
        window.location.href = `/products/${result.id}`;
    },
    
    clearSearch() {
        this.query = '';
        this.results = [];
        this.showResults = false;
    }
}));

Alpine.data('productFilter', () => ({
    filters: {
        category: '',
        brand: '',
        priceMin: '',
        priceMax: '',
        rating: '',
        inStock: false
    },
    products: [],
    filteredProducts: [],
    isLoading: false,
    
    init() {
        this.loadProducts();
    },
    
    loadProducts() {
        this.isLoading = true;
        
        // Simulate API call - replace with actual implementation
        fetch('/api/products')
            .then(response => response.json())
            .then(data => {
                this.products = data.products || [];
                this.applyFilters();
                this.isLoading = false;
            })
            .catch(error => {
                console.error('Error loading products:', error);
                this.isLoading = false;
            });
    },
    
    applyFilters() {
        this.filteredProducts = this.products.filter(product => {
            return (
                (!this.filters.category || product.category === this.filters.category) &&
                (!this.filters.brand || product.brand === this.filters.brand) &&
                (!this.filters.priceMin || product.price >= this.filters.priceMin) &&
                (!this.filters.priceMax || product.price <= this.filters.priceMax) &&
                (!this.filters.rating || product.rating >= this.filters.rating) &&
                (!this.filters.inStock || product.stock > 0)
            );
        });
    },
    
    clearFilters() {
        this.filters = {
            category: '',
            brand: '',
            priceMin: '',
            priceMax: '',
            rating: '',
            inStock: false
        };
        this.applyFilters();
    },
    
    updateFilter(key, value) {
        this.filters[key] = value;
        this.applyFilters();
    }
}));

Alpine.data('wishlist', () => ({
    items: [],
    
    init() {
        this.loadWishlist();
    },
    
    loadWishlist() {
        const saved = localStorage.getItem('wishlist');
        if (saved) {
            this.items = JSON.parse(saved);
        }
    },
    
    saveWishlist() {
        localStorage.setItem('wishlist', JSON.stringify(this.items));
    },
    
    addItem(product) {
        if (!this.isInWishlist(product.id)) {
            this.items.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image
            });
            this.saveWishlist();
            this.showToast('Added to wishlist!', 'success');
        } else {
            this.showToast('Item already in wishlist', 'warning');
        }
    },
    
    async removeItem(id) {
        const result = await window.utils.showDeleteConfirm(
            'Remove from Wishlist',
            'Are you sure you want to remove this item from your wishlist?'
        );
        
        if (result.isConfirmed) {
            this.items = this.items.filter(item => item.id !== id);
            this.saveWishlist();
            this.showToast('Removed from wishlist', 'info');
        }
    },
    
    isInWishlist(id) {
        return this.items.some(item => item.id === id);
    },
    
    toggleItem(product) {
        if (this.isInWishlist(product.id)) {
            this.removeItem(product.id);
        } else {
            this.addItem(product);
        }
    },
    
    showToast(message, type = 'info') {
        if (window.utils) {
            window.utils.showToast(message, type);
        }
    }
}));

Alpine.data('newsletter', () => ({
    email: '',
    isSubmitting: false,
    isSubscribed: false,
    
    async subscribe() {
        if (!this.email || !this.isValidEmail(this.email)) {
            await window.utils.showError('Invalid Email', 'Please enter a valid email address');
            return;
        }
        
        this.isSubmitting = true;
        window.utils.showLoading('Subscribing...', 'Please wait while we process your subscription');
        
        try {
            // Simulate API call - replace with actual implementation
            const response = await fetch('/api/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: this.email })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                this.isSubscribed = true;
                this.email = '';
                window.utils.closeLoading();
                await window.utils.showSuccess('Subscribed!', 'You have been successfully subscribed to our newsletter');
            } else {
                throw new Error(data.message || 'Subscription failed');
            }
        } catch (error) {
            console.error('Newsletter subscription error:', error);
            window.utils.closeLoading();
            await window.utils.showError('Subscription Failed', error.message || 'Failed to subscribe. Please try again.');
        } finally {
            this.isSubmitting = false;
        }
    },
    
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },
    
    showToast(message, type = 'info') {
        if (window.utils) {
            window.utils.showToast(message, type);
        }
    }
}));

// Initialize Alpine
Alpine.start();

// Additional storefront functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product image gallery
    const productImages = document.querySelectorAll('.product-image-gallery img');
    if (productImages.length > 0) {
        productImages.forEach((img, index) => {
            img.addEventListener('click', function() {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black/80 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="relative max-w-4xl max-h-full p-4">
                        <img src="${this.src}" alt="${this.alt}" class="max-w-full max-h-full object-contain">
                        <button onclick="this.parentElement.parentElement.remove()" class="absolute top-2 right-2 text-white hover:text-gray-300">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                `;
                document.body.appendChild(modal);
            });
        });
    }
    
    // Initialize quantity selectors
    const quantitySelectors = document.querySelectorAll('.quantity-selector');
    quantitySelectors.forEach(selector => {
        const input = selector.querySelector('input');
        const minusBtn = selector.querySelector('.quantity-minus');
        const plusBtn = selector.querySelector('.quantity-plus');
        
        minusBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
        
        plusBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value) || 1;
            input.value = currentValue + 1;
        });
    });
    
    // Initialize product comparison
    const compareButtons = document.querySelectorAll('.compare-btn');
    compareButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            // Add comparison logic here
            this.classList.toggle('active');
            this.textContent = this.classList.contains('active') ? 'Remove from Compare' : 'Add to Compare';
        });
    });
    
    // Initialize lazy loading for images
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
});

export { Alpine };
