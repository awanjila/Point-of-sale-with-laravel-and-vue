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

    <!-- Product Grid (Scrollable) -->
    <div class="product-grid">
      <div v-if="paginatedProducts.length" class="grid-container">
        <div 
          v-for="product in paginatedProducts" 
          :key="product.id"
          @click="addToCart(product)"
          class="grid-item"
          :class="getStockColor(product.product_store)" 
        >
          <div class="product-image">
            <img 
              :src="product.product_image ? `${product.product_image}` : 'assets/images/placeholder-img.png'"
              :alt="product.product_name"
              @error="handleImageError"
            />
          </div>
          
          <div class="product-info">
            <div class="info-row product-name-container">
              <span class="product-name" :title="product.product_name">{{ product.product_name }}</span>
            </div>
            <div class="info-row">
              <span class="stock-info">{{ product.product_store }} Remaining</span>
            </div>
            <div class="info-row">
              <span class="product-price">Ksh {{ product.selling_price }}.00</span>
            </div>
          </div>
          
          <button class="add-btn">
            <i class="fas fa-cart-plus"></i>
          </button>
        </div>
      </div>

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
            <i class="fas fa-arrow-left"></i> 
          </a>
        </li>
        <li class="page-item" :class="{ active: page === currentPage }" v-for="page in totalPages" :key="page">
          <a class="page-link" @click="goToPage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="currentPage < totalPages && currentPage++">
             <i class="fas fa-arrow-right"></i>
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
import toastr from 'toastr';

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

// Add sound effect
const addToCartSound = new Audio('/assets/sound/ding-80828.mp3'); // Add your sound file path

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
  
  // Play sound
  addToCartSound.currentTime = 0; // Reset sound to start
  addToCartSound.play()
    .catch(error => console.log('Error playing sound:', error)); // Handle any playback errors
  
  // Show toastr message
  toastr.success(`${product.product_name} added to cart`, 'Success', {
    timeOut: 2000,
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-bottom-right'
  });
};

// Apply background color based on stock levels
const getStockColor = (stock) => {
  if (stock > 50) return 'high-stock'; // Green background for stock > 50
  if (stock >= 15 && stock <= 50) return 'medium-stock'; // Yellow background for stock between 15 and 50
  return 'low-stock'; // Red background for stock < 15
};

// Add this new method to handle image loading errors
const handleImageError = (e) => {
  e.target.src = 'assets/images/placeholder-img.png'; // Update fallback image path
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

/* Product Grid Styling */
.product-grid {
  height: 450px;
  overflow-y: auto;
  padding: 10px;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
  gap: 12px;
  padding: 10px;
}

.grid-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.grid-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.product-image {
  width: 100px;
  height: 100px;
  margin-bottom: 8px;
}

.product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
}

.product-info {
  width: 100%;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 5px;
}

.info-row {
  width: 100%;
  overflow: hidden;
}

.product-name-container {
  height: 35px;
}

.product-name {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  font-weight: bold;
  font-size: 0.9rem;
  line-height: 1.2;
}

.stock-info {
  font-size: 0.8rem;
  color: #666;
  display: block;
}

.product-price {
  font-weight: bold;
  color: #c02323;
  display: block;
  font-size: 1.1rem;
}

.add-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  width: 35px;
  height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  color: #28a745;
  transition: all 0.3s ease;
  opacity: 0;
  z-index: 2;
}

.grid-item:hover .add-btn {
  opacity: 1;
}

.add-btn:hover {
  transform: translate(-50%, -50%) scale(1.1);
  background: white;
}

.grid-item::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.1);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.grid-item:hover::after {
  opacity: 1;
}

/* Stock level color changes */
.high-stock {
  background-color: #d4edda;
}

.medium-stock {
  background-color: #fff3cd;
}

.low-stock {
  background-color: #f8d7da;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 8px;
  }

  .product-image {
    width: 90px;
    height: 90px;
  }
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

/* Add these responsive styles */
@media screen and (max-width: 768px) {
  .product-container {
    padding: 8px;
  }

  .search-bar {
    margin-bottom: 8px;
  }

  .search-bar input {
    padding: 6px;
    font-size: 0.9rem;
  }

  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 8px;
    padding: 5px;
  }

  .grid-item {
    padding: 5px;
  }

  .product-image {
    width: 80px;
    height: 80px;
  }

  .product-info {
    gap: 2px;
    padding: 3px;
  }

  .product-name-container {
    height: 32px;
    font-size: 0.75rem;
  }

  .product-code,
  .product-size {
    font-size: 0.7rem;
  }

  .add-btn {
    width: 30px;
    height: 30px;
  }
}

/* For very small screens */
@media screen and (max-width: 480px) {
  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 6px;
  }

  .product-image {
    width: 70px;
    height: 70px;
  }

  .product-name-container {
    height: 28px;
    font-size: 0.7rem;
  }

  .product-code,
  .product-size {
    font-size: 0.65rem;
  }

  .add-btn {
    width: 25px;
    height: 25px;
  }
}

/* Optimize for touch devices */
@media (hover: none) {
  .add-btn {
    opacity: 1; /* Always show add button on touch devices */
    background: rgba(255, 255, 255, 0.9);
  }

  .grid-item {
    touch-action: manipulation; /* Optimize for touch */
  }

  .product-grid {
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
  }
}

/* Adjust grid height for different screen sizes */
@media screen and (max-width: 768px) {
  .product-grid {
    height: calc(100vh - 180px);
  }
}

/* Improve touch targets */
@media (hover: none) {
  .search-bar input {
    height: 40px; /* Larger touch target */
  }

  .grid-item {
    min-height: 120px; /* Ensure enough space for touch */
  }
}

/* Handle landscape mode on mobile */
@media screen and (max-width: 768px) and (orientation: landscape) {
  .grid-container {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  }

  .product-grid {
    height: calc(100vh - 150px);
  }
}
</style>