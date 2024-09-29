<template>
  <div class="product-container">
    <!-- Search Input -->
    <div class="search-bar">
      <input 
        type="text" 
        v-model="searchQuery" 
        class="form-control" 
        placeholder="Search for products..." 
      />
    </div>

    <!-- Product Grid -->
    <div class="row mx-0">
      <div class="col-4 px-2" v-for="product in paginatedProducts" :key="product.id">
        <div class="item-box text-center" @click="addToCart(product)">
          <div class="txt-box">
            <span>Ksh {{ product.selling_price }}.00</span>
          </div>
          <div class="img-box">
            <img :src="product.product_image" class="img-fluid" alt="product image" />
          </div>
          <div class="txt-box item-name">
            <span>{{ product.product_name }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination Controls -->
    <nav aria-label="Product pagination" v-if="totalPages > 1">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click="currentPage > 1 && currentPage--">Previous</a>
        </li>
        <li class="page-item" :class="{ active: page === currentPage }" v-for="page in totalPages" :key="page">
          <a class="page-link" @click="goToPage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="currentPage < totalPages && currentPage++">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useCartStore } from './stores/cart';

// Search query reactive variable
const searchQuery = ref(''); // For filtering products by search term

const props = defineProps({
  selectedCategory: {
    type: Object,
    default: null,
  },
});

const products = ref([]);
const cartStore = useCartStore();

// Pagination state
const currentPage = ref(1);
const itemsPerPage = ref(20); // Adjust the number of items per page

// Fetch Products from API
const getProducts = async () => {
  try {
    const res = await axios.get('/api/pos/products');
    products.value = res.data;
  } catch (error) {
    console.error('Failed to load products:', error);
  }
};

// Handle product filtering based on selected category and search query
const filteredProducts = computed(() => {
  let filtered = products.value;

  // Filter by selected category
  if (props.selectedCategory) {
    filtered = filtered.filter(product => product.category_id === props.selectedCategory.id);
  }

  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(product => 
      product.product_name.toLowerCase().includes(query)
    );
  }

  return filtered;
});

// Pagination logic
const totalPages = computed(() => Math.ceil(filteredProducts.value.length / itemsPerPage.value));

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredProducts.value.slice(start, end);
});

// Go to a specific page
const goToPage = (page) => {
  currentPage.value = page;
};

// Add product to cart
const addToCart = (product) => {
  cartStore.addToCart(product);
};

// Fetch products on component mount
onMounted(() => {
  getProducts();
});
</script>


<style scoped>
/* Lato and Sans-serif fonts */
body {
  font-family: 'Lato', sans-serif;
}

/* Product Container Scroll */
.product-container {
  max-height: 80vh;
  overflow-y: auto;
  padding: 10px;
}

/* Search Bar Styling */
.search-bar {
  margin-bottom: 20px;
}

.search-bar input {
  padding: 10px;
  width: 100%;
  border-radius: 5px;
  border: 1px solid #ccc;
}

/* Adjust margins and paddings for rows */
.row {
  margin-bottom: 15px;
}

/* Product Card Styling */
.item-box {
  border: 1px solid #ddd;
  padding: 15px;
  background-color: white;
  cursor: pointer;
  transition: box-shadow 0.3s ease;
  margin-bottom: 20px;
}

.item-box:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Text Box Margin */
.txt-box {
  margin-top: 10px;
}

/* Product Image Styling */
.img-box img {
  width: 100%;
  height: auto;
  margin-bottom: 10px;
}

/* Pagination Styling */
.pagination {
  margin-top: 15px;
}

.pagination .page-item.active .page-link {
  background-color: #c02323;
  border-color: #c02323;
}

/* Scrollbar Styling */
.product-container::-webkit-scrollbar {
  width: 8px;
}

.product-container::-webkit-scrollbar-thumb {
  background-color: #c02323;
  border-radius: 10px;
}

.product-container::-webkit-scrollbar-track {
  background-color: #f1f1f1;
}
</style>

