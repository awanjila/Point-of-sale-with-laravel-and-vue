<template>
  <div class="product-area">
    <!-- Product Grid -->
    <div class="item-area-box row mx-0">
      <div class="col-4 px-1" v-for="product in paginatedProducts" :key="product.id">
        <div class="item-box text-center" @click="addToCart(product)">
          <div class="txt-box">
            <span>Ksh {{ product.selling_price }}</span>
          </div>
          <div class="img-box">
            <img :src="product.product_image" class="img-fluid" alt="product image">
          </div>
          <div class="txt-box item-name">
            <span>{{ product.product_name }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Numbered Pagination Section (now below products) -->
    <nav aria-label="Page navigation" v-if="totalPages > 1">
      <ul class="pagination justify-content-center">
        <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
          <button class="page-link" @click="goToPage(page)">{{ page }}</button>
        </li>
      </ul>
      <p class="text-center">Page {{ currentPage }} of {{ totalPages }}</p>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useCartStore } from './stores/cart';

const products = ref([]);
const currentPage = ref(1);
const itemsPerPage = 18; // Define how many items per page
const cartStore = useCartStore();

const getProducts = async () => {
  try {
    const res = await axios.get('/api/pos/products');
    products.value = res.data;
  } catch (error) {
    console.error('Failed to load products');
  }
};

onMounted(() => {
  getProducts();
});

// Computed property for pagination
const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = currentPage.value * itemsPerPage;
  return products.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(products.value.length / itemsPerPage));

const goToPage = (page) => {
  currentPage.value = page;
};

// Add to cart functionality
const addToCart = (product) => {
  cartStore.addToCart(product);
};
</script>

<style scoped>
/* Reduce space between product items */
.item-area-box {
  display: flex;
  flex-wrap: wrap;
}

.item-box {
  margin-bottom: 10px;
  padding: 10px;
  background-color: #fff;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

.img-box img {
  width: 100%;
}

/* Pagination styling */
.pagination {
  margin-top: 15px;
}

.pagination .page-item.active .page-link {
  background-color: #007bff;
  border-color: #007bff;
}
</style>
