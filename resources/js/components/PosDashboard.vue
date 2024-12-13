<template>
  <div class="pos-dashboard-container">
    <div class="pos-dashboard">
      <div class="row">
        <!-- Cart Section with Header -->
        <div class="col-6 cart-container">
          <!-- Header Section -->
          <div class="header">
            <div class="header-section left">
              <div class="nav-item">
                <a href="/dashboard">
                  <i class="fas fa-home"></i>
                  <span class="nav-label">To Dashboard</span>
                </a>
              </div>
            </div>

            <div class="header-section center">
              <img :src="'/assets/images/logo-dark.png'" alt="Logo" class="logo"/>
            </div>

            <div class="header-section right">
              <div class="user-info">
                <i class="fas fa-user"></i>
                <span class="user-name">{{ userData.name }}</span>
              </div>
              
              <a href="#" @click.prevent="logout" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
              </a>
            </div>
          </div>

          <!-- Cart Section -->
<Cart :cart="cartStore.cart" :userData="userData" @resetCart="resetCart" />

        </div>

        <!-- Products Section -->
        <div class="col-6 product-container">
          <!-- Category and Brand Buttons (Full Width) -->
          <div class="button-container">
            <button @click="toggleCategoryMenu" class="btn-category">List of Categories</button>
            <!-- <button @click="toggleBrandsMenu" class="btn-brand">List of Brands</button> -->
          </div>
          <!-- <Products :selectedCategory="selectedCategory" /> -->
          <ProductsImages :selectedCategory="selectedCategory" />
        </div>
      </div>

      <!-- Category Menu -->
      <CategoryMenu
        v-if="showCategoryMenu"
        @close="toggleCategoryMenu"
        @selectCategory="selectCategory"
      />

      <!-- Customer Modal -->
      <CustomerForm :showModal="showCustomerForm" @closeModal="toggleCustomerForm" />
    </div>
  </div>
</template>


<script>
import Cart from './CartComponent.vue';
// import Products from './ProductsComponent.vue';
import ProductsImages from './ProductsImagesComponent.vue';
import CategoryMenu from './CategoryMenu.vue';
import CustomerForm from './CustomerForm.vue';
import { useCartStore } from './stores/cart';
import axios from 'axios';

export default {
  components: { Cart,ProductsImages, CategoryMenu, CustomerForm },
  

  props: {
  userData: {
    type: Object,
    required: true,
    default: () => ({
      name: 'Guest', // Default value if no user data is provided
    }),
  },
},

  setup() {
    const cartStore = useCartStore();

    return {
      cartStore,
    };
  },
  data() {
    return {
      selectedCategory: null,
      showCategoryMenu: false,
      showCustomerForm: false,
      isHovered: false, // Track hover state
    };
  },
  methods: {
    toggleCategoryMenu() {
      this.showCategoryMenu = !this.showCategoryMenu;
    },
    selectCategory(category) {
      this.selectedCategory = category;
      this.showCategoryMenu = false;
    },
    toggleCustomerForm() {
      this.showCustomerForm = !this.showCustomerForm;
    },
    resetCart() {
      this.cartStore.clearCart();
    },
    printReceipt() {
      // Implement print functionality
      window.print();
    },
    async logout() {
      try {
        await axios.post('/logout');
        window.location.href = '/login';
      } catch (error) {
        console.error('Logout failed:', error);
      }
    }
  },
};
</script>

<style scoped>
/* Main Container for the POS Dashboard */
.pos-dashboard-container {
  padding: 20px;
  background-color: #f0f0f0;
}

/* Flexbox layout for the entire page */
.pos-dashboard {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  height: 100vh; /* Full viewport height */
  padding: 10px;
  box-sizing: border-box;
}

/* Cart Section */
.cart-container {
  flex: 1;
  padding: 15px;
  margin-right: 10px;
  background-color: #f8f9fa;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

/* Header Section */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
  margin-bottom: 15px;
}

.header-section {
  display: flex;
  align-items: center;
  gap: 25px;
}

.header-section.left {
  flex: 1;
}

.header-section.center {
  flex: 2;
  justify-content: center;
}

.header-section.right {
  flex: 1;
  justify-content: flex-end;
}

.logo {
  height: 60px;
}

.nav-item a {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
  text-decoration: none;
  color: inherit;
}

.nav-item i {
  font-size: 20px;
  color: #333;
}

.nav-label {
  font-size: 12px;
  color: #666;
  font-weight: 500;
}

/* Button container for Category and Brand buttons */
.button-container {
  display: flex;
  flex-direction: column; /* Stack buttons vertically */
  gap: 10px; /* Space between buttons */
  margin-bottom: 20px;
}

/* Style for Category and Brand Buttons */
.btn-category, .btn-brand {
  padding: 15px 20px;
  background-color: white; /* White background */
  color: #333; /* Default text color */
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 18px;
  cursor: pointer;
  width: 100%; /* Full width buttons */
  text-align: center; /* Center text */
  transition: background-color 0.3s ease;
}

/* Hover effects with different colors */
.btn-category:hover {
  background-color: #ffb74d; /* Orange on hover */
}

.btn-brand:hover {
  background-color: #4caf50; /* Green on hover */
}

.btn-category:focus, .btn-brand:focus {
  outline: none;
  background-color: #f0f0f0; /* Lighter gray on focus */
}

/* Product Section */
.product-container {
  flex: 1;
  padding: 15px;
  margin-left: 10px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.logout-btn {
  background: none;
  border: none;
  color: inherit;
  cursor: pointer;
  padding: 0;
  margin-left: 15px;
  font-size: 20px;
  text-decoration: none;
}

.logout-btn:hover {
  color: #dc3545;
}

.user-info {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 5px;
}

.user-info i {
  font-size: 20px;
  color: #333;
}

.user-name {
  font-size: 12px;
  color: #666;
  font-weight: 500;
}

/* Add to your existing styles */
@media screen and (max-width: 768px) {
  .pos-dashboard .row {
    flex-direction: column;
  }

  .col-6 {
    width: 100%;
    margin: 10px 0;
  }

  .cart-container,
  .product-container {
    margin: 0;
    height: auto;
  }

  .header {
    padding: 10px;
  }

  .logo {
    height: 40px;
  }

  .header-icons {
    gap: 15px;
  }
}

</style>
