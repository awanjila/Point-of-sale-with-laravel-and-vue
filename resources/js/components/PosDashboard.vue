<template>
  <div class="container pos-dashboard">
    <div class="row justify-content-between">
      <!-- Cart Section (Left Side) -->
      <div class="col-md-5 cart-container shadow-sm p-4 mb-5 bg-white rounded mx-auto">
        <Cart />
      </div>

      <!-- Products Section (Right Side) -->
      <div class="col-md-6 product-container shadow-sm p-4 mb-5 bg-white rounded ml-4"> <!-- Added margin-left -->
        <!-- Buttons for Categories and Brands inside the product component -->
        <div class="row justify-content-end mb-4">
          <div class="col-md-6">
            <button class="btn category-button w-100" @click="openCategoryMenu">List of Categories</button>
          </div>
          <div class="col-md-6">
            <button class="btn brand-button w-100" @click="openBrandsMenu">List of Brands</button>
          </div>
        </div>
        <Products :selectedCategory="selectedCategory" />
      </div>
    </div>

    <!-- Category Side Menu -->
    <CategoryMenu
      v-if="showCategoryMenu"
      @close="showCategoryMenu = false"
      @categorySelected="updateSelectedCategory"
    />
  </div>

  <CustomerForm :showModal="isModalVisible" @close="isModalVisible = false" />
  <button @click="isModalVisible = true">Add Customer</button>
</template>

<script>
import { ref } from 'vue';
import Products from '../components/ProductsComponent.vue';
import Cart from '../components/CartComponent.vue';
import CategoryMenu from '../components/CategoryMenu.vue';
import CustomerForm from './CustomerForm.vue';

const isModalVisible = ref(false);

export default {
  components: {
    Products,
    Cart,
    CategoryMenu,
  },
  data() {
    return {
      selectedCategory: null, // This will hold the currently selected category
      showCategoryMenu: false, // Controls the visibility of the category menu
    };
  },
  methods: {
    openCategoryMenu() {
      this.showCategoryMenu = true;
    },
    openBrandsMenu() {
      // Logic to open the brand menu
    },
    updateSelectedCategory(category) {
      this.selectedCategory = category;
      this.showCategoryMenu = false;
    },
  },
};
</script>

<style scoped>
.pos-dashboard {
  margin-top: 20px;
}

/* Center the cart */
.cart-container {
  padding: 20px;
  margin-right: auto;
  margin-left: auto;
  text-align: center;
  background-color: #f9f9f9;
  border-radius: 10px;
}

/* Product container padding increased with margin-left */
.product-container {
  padding: 30px;
  background-color: #f9f9f9;
  border-radius: 10px;
  margin-left: 20px; /* Added space between cart and product */
}

/* Button for categories and brands */
.category-button {
  background-color: white;
  color: #007bff;
  border: 2px solid #007bff;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.brand-button {
  background-color: white;
  color: #28a745;
  border: 2px solid #28a745;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Hover effects - button colors remain the same */
.category-button:hover,
.brand-button:hover {
  background-color: white;
  color: inherit;
}

/* Spacing for buttons */
.row.mb-4 .col-md-6 {
  margin-bottom: 10px;
}
</style>
