import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

// Admin specific Alpine.js components
Alpine.data('dashboard', () => ({
    stats: {
        totalSales: 0,
        totalOrders: 0,
        totalCustomers: 0,
        totalProducts: 0
    },
    recentOrders: [],
    topProducts: [],
    salesChart: null,
    
    init() {
        this.loadDashboardData();
    },
    
    loadDashboardData() {
        // Simulate API calls - replace with actual implementation
        Promise.all([
            fetch('/api/admin/stats').then(r => r.json()),
            fetch('/api/admin/recent-orders').then(r => r.json()),
            fetch('/api/admin/top-products').then(r => r.json())
        ]).then(([stats, orders, products]) => {
            this.stats = stats;
            this.recentOrders = orders;
            this.topProducts = products;
            this.initCharts();
        }).catch(error => {
            console.error('Error loading dashboard data:', error);
        });
    },
    
    initCharts() {
        // Sales chart
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            this.salesChart = new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [12000, 19000, 15000, 25000, 22000, 30000],
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    }
}));

Alpine.data('dataTable', () => ({
    data: [],
    filteredData: [],
    searchQuery: '',
    sortField: '',
    sortDirection: 'asc',
    currentPage: 1,
    itemsPerPage: 10,
    selectedItems: [],
    
    init() {
        this.loadData();
    },
    
    loadData() {
        // Simulate API call - replace with actual implementation
        fetch(this.endpoint)
            .then(response => response.json())
            .then(data => {
                this.data = data;
                this.filteredData = [...data];
            })
            .catch(error => {
                console.error('Error loading data:', error);
            });
    },
    
    search() {
        this.filteredData = this.data.filter(item => {
            return Object.values(item).some(value => 
                String(value).toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        });
        this.currentPage = 1;
    },
    
    sort(field) {
        if (this.sortField === field) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortField = field;
            this.sortDirection = 'asc';
        }
        
        this.filteredData.sort((a, b) => {
            const aVal = a[field];
            const bVal = b[field];
            
            if (aVal < bVal) return this.sortDirection === 'asc' ? -1 : 1;
            if (aVal > bVal) return this.sortDirection === 'asc' ? 1 : -1;
            return 0;
        });
    },
    
    get paginatedData() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.filteredData.slice(start, end);
    },
    
    get totalPages() {
        return Math.ceil(this.filteredData.length / this.itemsPerPage);
    },
    
    goToPage(page) {
        this.currentPage = page;
    },
    
    toggleSelectAll() {
        if (this.selectedItems.length === this.paginatedData.length) {
            this.selectedItems = [];
        } else {
            this.selectedItems = this.paginatedData.map(item => item.id);
        }
    },
    
    toggleSelectItem(id) {
        const index = this.selectedItems.indexOf(id);
        if (index > -1) {
            this.selectedItems.splice(index, 1);
        } else {
            this.selectedItems.push(id);
        }
    },
    
    isSelected(id) {
        return this.selectedItems.includes(id);
    },
    
    async deleteSelected() {
        if (this.selectedItems.length === 0) return;
        
        const result = await window.utils.showDeleteConfirm(
            'Delete Selected Items',
            `Are you sure you want to delete ${this.selectedItems.length} item(s)? This action cannot be undone.`
        );
        
        if (result.isConfirmed) {
            window.utils.showLoading('Deleting...', 'Please wait while we delete the selected items');
            
            try {
                const response = await fetch('/api/admin/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ ids: this.selectedItems })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    this.data = this.data.filter(item => !this.selectedItems.includes(item.id));
                    this.filteredData = this.data;
                    this.selectedItems = [];
                    window.utils.closeLoading();
                    await window.utils.showSuccess('Items Deleted', 'Selected items have been successfully deleted');
                } else {
                    throw new Error(data.message || 'Delete operation failed');
                }
            } catch (error) {
                console.error('Error deleting items:', error);
                window.utils.closeLoading();
                await window.utils.showError('Delete Failed', error.message || 'Error deleting items. Please try again.');
            }
        }
    },
    
    showToast(message, type = 'info') {
        if (window.utils) {
            window.utils.showToast(message, type);
        }
    }
}));

Alpine.data('form', () => ({
    data: {},
    errors: {},
    isSubmitting: false,
    
    init() {
        this.loadData();
    },
    
    loadData() {
        // Load initial data if editing
        if (this.editMode) {
            fetch(`${this.endpoint}/${this.itemId}`)
                .then(response => response.json())
                .then(data => {
                    this.data = data;
                })
                .catch(error => {
                    console.error('Error loading data:', error);
                });
        }
    },
    
    async submit() {
        this.errors = {};
        this.isSubmitting = true;
        
        if (!this.validate()) {
            this.isSubmitting = false;
            return;
        }
        
        window.utils.showLoading('Saving...', 'Please wait while we save your changes');
        
        const method = this.editMode ? 'PUT' : 'POST';
        const url = this.editMode ? `${this.endpoint}/${this.itemId}` : this.endpoint;
        
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(this.data)
            });
            
            const data = await response.json();
            
            if (data.errors) {
                this.errors = data.errors;
                window.utils.closeLoading();
                await window.utils.showError('Validation Error', 'Please check the form for errors');
            } else {
                window.utils.closeLoading();
                await window.utils.showSuccess('Saved!', data.message || 'Your changes have been saved successfully');
                
                if (this.redirectAfterSave) {
                    setTimeout(() => {
                        window.location.href = this.redirectAfterSave;
                    }, 1500);
                }
            }
        } catch (error) {
            console.error('Error saving data:', error);
            window.utils.closeLoading();
            await window.utils.showError('Save Failed', 'Error saving data. Please try again.');
        } finally {
            this.isSubmitting = false;
        }
    },
    
    validate() {
        this.errors = {};
        
        // Add custom validation logic here
        if (!this.data.name) {
            this.errors.name = 'Name is required';
        }
        
        return Object.keys(this.errors).length === 0;
    },
    
    showToast(message, type = 'info') {
        if (window.utils) {
            window.utils.showToast(message, type);
        }
    }
}));

Alpine.data('modal', () => ({
    isOpen: false,
    title: '',
    content: '',
    
    open(title, content) {
        this.title = title;
        this.content = content;
        this.isOpen = true;
        document.body.classList.add('overflow-hidden');
    },
    
    close() {
        this.isOpen = false;
        document.body.classList.remove('overflow-hidden');
    },
    
    confirm(title, message, callback) {
        this.open(title, `
            <div class="text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-6">${message}</p>
                <div class="flex justify-center space-x-3">
                    <button onclick="this.closest('[x-data]').__x.$data.close()" class="btn-secondary">Cancel</button>
                    <button onclick="this.closest('[x-data]').__x.$data.executeCallback()" class="btn-primary">Confirm</button>
                </div>
            </div>
        `);
        this._callback = callback;
    },
    
    executeCallback() {
        if (this._callback) {
            this._callback();
        }
        this.close();
    }
}));

Alpine.data('notifications', () => ({
    notifications: [],
    
    init() {
        this.loadNotifications();
        // Poll for new notifications every 30 seconds
        setInterval(() => this.loadNotifications(), 30000);
    },
    
    loadNotifications() {
        fetch('/api/admin/notifications')
            .then(response => response.json())
            .then(data => {
                this.notifications = data;
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
            });
    },
    
    markAsRead(id) {
        fetch(`/api/admin/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(() => {
            this.notifications = this.notifications.map(notification => 
                notification.id === id ? { ...notification, read: true } : notification
            );
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    },
    
    get unreadCount() {
        return this.notifications.filter(n => !n.read).length;
    }
}));

// Initialize Alpine
Alpine.start();

// Additional admin functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize data tables
    const tables = document.querySelectorAll('.data-table');
    tables.forEach(table => {
        // Add sorting functionality
        const headers = table.querySelectorAll('th[data-sort]');
        headers.forEach(header => {
            header.addEventListener('click', function() {
                const field = this.dataset.sort;
                // Trigger Alpine.js sort method
                const alpineComponent = this.closest('[x-data]');
                if (alpineComponent && alpineComponent.__x) {
                    alpineComponent.__x.$data.sort(field);
                }
            });
        });
    });
    
    // Initialize file uploads
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const preview = document.getElementById(this.dataset.preview);
            if (preview && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Initialize date pickers
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // Add custom styling or functionality if needed
    });
    
    // Initialize rich text editors
    const textareas = document.querySelectorAll('textarea[data-editor]');
    textareas.forEach(textarea => {
        // Initialize rich text editor here
        // This would typically involve a library like TinyMCE or Quill
    });
    
    // Initialize image galleries
    const galleries = document.querySelectorAll('.image-gallery');
    galleries.forEach(gallery => {
        const images = gallery.querySelectorAll('img');
        images.forEach((img, index) => {
            img.addEventListener('click', function() {
                // Open image in modal or lightbox
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
    });
    
    // Initialize auto-save for forms
    const autoSaveForms = document.querySelectorAll('form[data-auto-save]');
    autoSaveForms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', window.utils.debounce(() => {
                // Auto-save logic here
                console.log('Auto-saving form...');
            }, 2000));
        });
    });
});

export { Alpine, Chart };
