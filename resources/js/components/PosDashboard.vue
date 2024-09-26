<template>
  <div class="container pos-dashboard">
    <!-- Row for List of Categories and Brands -->
    <div class="row mb-3">
      <div class="col-md-6">
        <button class="btn btn-primary w-100" @click="openCategoryMenu">List of Categories</button>
      </div>
      <div class="col-md-6">
        <button class="btn btn-primary w-100" @click="openBrandsMenu">List of Brands</button>
      </div>
    </div>

    <div class="row justify-content-between">
      <!-- Products Section (Left Side) -->
      <div class="col-md-7 product-container shadow-sm p-3 mb-5 bg-white rounded">
        <Products :selectedCategory="selectedCategory" />
      </div>

      <!-- Cart Section (Right Side) -->
      <div class="col-md-5 cart-container shadow-sm p-3 mb-5 bg-white rounded mx-auto">
        <Cart />
      </div>
    </div>

    <!-- Category Side Menu -->
    <CategoryMenu
      v-if="showCategoryMenu"
      @close="showCategoryMenu = false"
      @categorySelected="updateSelectedCategory"
    />
  </div>
</template>

<script>
import Products from '../components/ProductsComponent.vue';
import Cart from '../components/CartComponent.vue';
import CategoryMenu from '../components/CategoryMenu.vue';

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
  padding: 15px;
  margin-right: auto;
  margin-left: auto;
  text-align: center;
  background-color: #f9f9f9;
  border-radius: 10px;
}

.product-container {
  padding: 15px;
  background-color: #f9f9f9;
  border-radius: 10px;
}
</style>
