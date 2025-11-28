// Product Cart Vue Component
export function mountProductCart() {
  if (typeof window.Vue === 'undefined') return;

  const { createApp } = window.Vue;

  createApp({
    data() {
      return {
        cart: [],
        cartCount: 0,
        cartTotal: 0
      }
    },
    mounted() {
      this.loadCart();
      this.bindEvents();
    },
    methods: {
      loadCart() {
        const savedCart = localStorage.getItem('storefront-cart');
        if (savedCart) {
          this.cart = JSON.parse(savedCart);
          this.updateCartDisplay();
        }
      },
      
      saveCart() {
        localStorage.setItem('storefront-cart', JSON.stringify(this.cart));
        this.updateCartDisplay();
      },
      
      updateCartDisplay() {
        this.cartCount = this.cart.reduce((sum, item) => sum + item.quantity, 0);
        this.cartTotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        // Update cart count badge
        const cartCountEl = document.getElementById('cartCount');
        if (cartCountEl) {
          cartCountEl.textContent = this.cartCount;
          cartCountEl.style.display = this.cartCount > 0 ? 'block' : 'none';
        }
      },
      
      bindEvents() {
        // Add to cart buttons
        document.addEventListener('click', (e) => {
          if (e.target.closest('.add-to-cart-btn')) {
            const btn = e.target.closest('.add-to-cart-btn');
            const productId = btn.dataset.productId;
            const productCard = btn.closest('.product-card');
            
            if (productCard) {
              this.addToCart(productCard, productId);
            }
          }
        });
        
        // Cart button click
        const cartBtn = document.getElementById('cartBtn');
        if (cartBtn) {
          cartBtn.addEventListener('click', () => {
            this.showCartModal();
          });
        }
      },
      
      addToCart(productCard, productId) {
        const title = productCard.querySelector('.card-title')?.textContent || 'Product';
        const priceText = productCard.querySelector('.h5.text-primary')?.textContent || '$0';
        const price = parseFloat(priceText.replace('$', '').replace(',', ''));
        
        const existingItem = this.cart.find(item => item.id === productId);
        
        if (existingItem) {
          existingItem.quantity += 1;
        } else {
          this.cart.push({
            id: productId,
            title: title,
            price: price,
            quantity: 1
          });
        }
        
        this.saveCart();
        this.showAddToCartToast(title);
      },
      
      showAddToCartToast(productName) {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'success',
            title: 'Added to Cart!',
            text: `${productName} has been added to your cart`,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
          });
        }
      },
      
      showCartModal() {
        if (typeof Swal !== 'undefined') {
          let cartHtml = '';
          
          if (this.cart.length === 0) {
            cartHtml = '<p class="text-muted">Your cart is empty</p>';
          } else {
            cartHtml = '<div class="list-group">';
            this.cart.forEach(item => {
              cartHtml += `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="mb-1">${item.title}</h6>
                    <small class="text-muted">$${item.price.toFixed(2)} each</small>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.productCart.updateQuantity('${item.id}', -1)">-</button>
                    <span class="badge bg-primary">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary" onclick="window.productCart.updateQuantity('${item.id}', 1)">+</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="window.productCart.removeFromCart('${item.id}')">×</button>
                  </div>
                </div>
              `;
            });
            cartHtml += '</div>';
            cartHtml += `<div class="mt-3 p-3 bg-light rounded">
              <div class="d-flex justify-content-between">
                <strong>Total: $${this.cartTotal.toFixed(2)}</strong>
                <button class="btn btn-primary" onclick="window.productCart.checkout()">Checkout</button>
              </div>
            </div>`;
          }
          
          Swal.fire({
            title: 'Shopping Cart',
            html: cartHtml,
            showCloseButton: true,
            showConfirmButton: false,
            width: '500px'
          });
        }
      },
      
      updateQuantity(productId, change) {
        const item = this.cart.find(item => item.id === productId);
        if (item) {
          item.quantity += change;
          if (item.quantity <= 0) {
            this.removeFromCart(productId);
          } else {
            this.saveCart();
            this.showCartModal(); // Refresh modal
          }
        }
      },
      
      removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.showCartModal(); // Refresh modal
      },
      
      checkout() {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'Checkout',
            text: 'Redirecting to checkout...',
            icon: 'info',
            timer: 2000,
            showConfirmButton: false
          });
        }
      }
    }
  }).mount('#storefront-app');
  
  // Make methods globally available for inline onclick handlers
  window.productCart = {
    updateQuantity: (productId, change) => {
      const app = document.querySelector('#storefront-app').__vue_app__;
      if (app) {
        app._instance.proxy.updateQuantity(productId, change);
      }
    },
    removeFromCart: (productId) => {
      const app = document.querySelector('#storefront-app').__vue_app__;
      if (app) {
        app._instance.proxy.removeFromCart(productId);
      }
    },
    checkout: () => {
      const app = document.querySelector('#storefront-app').__vue_app__;
      if (app) {
        app._instance.proxy.checkout();
      }
    }
  };
}
