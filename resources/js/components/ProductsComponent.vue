<template>
  <div class="product-area">
    <!-- Category and search code remains the same -->
    <div class="item-area-box row mx-0">
      <div class="col-6 col-md-4 px-1" v-for="product in filteredProducts" :key="product.id">
        <div class="item-box mt-0 text-center" @click="addToCart(product)">
          <div class="txt-box">
            <span>Ksh {{ product.selling_price }}</span>
          </div>
          <div class="img-box">
            <img :src="product.product_image" class="img-fluid" alt="">
          </div>
          <div class="txt-box item-name">
            <span>{{ product.product_name }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useCartStore } from './stores/cart'; // Import your cart store
import axios from 'axios';

const products = ref([]);
const categories = ref([]);
const selectedCategory = ref(null);
const searchQuery = ref("");
const loading = ref(true);
const error = ref(null);
const cartStore = useCartStore(); // Use the cart store

const getProducts = async () => {
  try {
    const res = await axios.get("/api/pos/products");
    products.value = res.data;
  } catch (err) {
    error.value = 'Failed to load products';
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const getCategories = async () => {
  try {
    const res = await axios.get("/api/pos/categories");
    categories.value = res.data;
  } catch (err) {
    error.value = 'Failed to load categories';
    console.error(err);
  }
};

onMounted(() => {
  getProducts();
  getCategories();
});

// Add product to cart using Pinia
const addToCart = (product) => {
  cartStore.addToCart(product);
};

// Computed property to filter products
const filteredProducts = computed(() => {
  let filtered = products.value;
  if (selectedCategory.value) {
    filtered = filtered.filter((product) => product.category_id === selectedCategory.value.id);
  }
  const search = searchQuery.value.toLowerCase();
  return filtered.filter((product) =>
    product.product_name.toLowerCase().includes(search) ||
    product.product_code.toLowerCase().includes(search)
  );
});
</script>

<style scoped>
.loading {
  text-align: center;
  margin: 20px 0;
}
</style>
