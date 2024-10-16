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

    <!-- Product List (Scrollable) -->
    <div class="product-list">
      <ul v-if="paginatedProducts.length" class="list-group">
        <li 
          class="list-group-item d-flex justify-content-between align-items-center product-item"
          v-for="product in paginatedProducts" 
          :key="product.id"
          @click="addToCart(product)"
          :class="getStockColor(product.product_store)" 
        >
          <div class="product-info">
            <span class="product-name">{{ product.product_name }}</span>
            <br>
            <span>  {{ product.product_store }} Remaining</span>
          </div>
          
          <span class="product-price">Ksh {{ product.selling_price }}.00</span>
          <button class="add-btn">
            <i class="fas fa-cart-plus"></i>
          </button>
        </li>
      </ul>

      <!-- No products found message -->
      <div v-else class="empty-state">
        No products found
      </div>
    </div>

    <!-- Pagination Controls -->
    <nav aria-label="Product pagination" v-if="totalPages > 1">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click="currentPage > 1 && currentPage--">
            <i class="fas fa-arrow-left"></i> Previous
          </a>
        </li>
        <li class="page-item" :class="{ active: page === currentPage }" v-for="page in totalPages" :key="page">
          <a class="page-link" @click="goToPage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="currentPage < totalPages && currentPage++">
            Next <i class="fas fa-arrow-right"></i>
          </a>
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
const searchQuery = ref('');

// Product props and cart store setup
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

// Apply background color based on stock levels
const getStockColor = (stock) => {
  if (stock > 50) return 'high-stock'; // Green background for stock > 50
  if (stock >= 15 && stock <= 50) return 'medium-stock'; // Yellow background for stock between 15 and 50
  return 'low-stock'; // Red background for stock < 15
};

// Fetch products on component mount
onMounted(() => {
  getProducts();
});
</script>

<style scoped>
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

/* Product List Styling */
.product-list {
  height: 400px; /* Fixed height for scrollable content */
  overflow-y: auto; /* Enables scrolling */
  padding: 0;
}

.list-group {
  list-style-type: none;
  padding: 0;
}

/* Ensure consistent layout */
.product-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  border: 1px solid #ddd;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-bottom: 10px;
  border-radius: 8px;
}

.product-info {
  flex-grow: 2; /* Adjust this to grow as needed */
}

.product-price {
  flex-grow: 1; /* Keep prices aligned */
  text-align: right; /* Right align prices */
}

.add-btn {
  background: none;
  border: none;
  color: #28a745;
  font-size: 1.2rem;
  cursor: pointer;
}

/* Stock level color changes */
.high-stock {
  background-color: #d4edda; /* Light green */
}

.medium-stock {
  background-color: #fff3cd; /* Light yellow */
}

.low-stock {
  background-color: #f8d7da; /* Light red */
}

/* Hover state for product items */
.product-item:hover {
  background-color: #f1f1f1;
}

/* Pagination Styling */
.pagination {
  margin-top: 15px;
}

.pagination .page-item.active .page-link {
  background-color: #c02323;
  border-color: #c02323;
}

/* Empty state styling for no products found */
.empty-state {
  text-align: center;
  margin-top: 50px;
  font-size: 1.2rem;
  color: #888;
}

/* Updated Product Container */
.product-container {
  width: 100%; /* Full width */
  height: auto; /* Adjust based on content */
  padding: 10px;
  background-color: #f8f9fa;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.product-header {
  text-align: center;
  font-size: 1.5rem;
  margin-bottom: 20px;
  color: #333;
}
</style>
