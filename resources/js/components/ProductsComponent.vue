<template>
  <div>
    <div class="row mx-0">
      <div class="col-4 px-1" v-for="product in filteredProducts" :key="product.id">
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
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';
import { useCartStore } from './stores/cart';

const products = ref([]);
const selectedCategory = defineProps(['selectedCategory']);
const cartStore = useCartStore();

const getProducts = async () => {
  try {
    const res = await axios.get('/api/pos/products');
    products.value = res.data;
  } catch (error) {
    console.error('Failed to load products:', error);
  }
};

// Handle case when selectedCategory is null or undefined
const filteredProducts = computed(() => {
  if (!selectedCategory || selectedCategory === null) {
    return products.value; // Return all products when no category is selected
  }
  return products.value.filter(product => product.category_id === selectedCategory.id);
});

onMounted(() => {
  getProducts();
});

const addToCart = (product) => {
  cartStore.addToCart(product);
};
</script>



<style scoped>
/* Lato and Sans-serif fonts */
body {
  font-family: 'Lato', sans-serif;
}

/* Adjust margins and paddings for rows */
.row {
  margin-bottom: 15px;
}

.btn {
  font-family: 'Lato', sans-serif;
  padding: 10px 20px;
  background-color: #007bff;
  border: none;
  color: white;
}

/* Category Button Styling */
.category-btn {
  background-color: #fff;
  color: #333;
  text-align: left;
  padding: 10px;
  border: 1px solid #ddd;
}

.category-btn:hover {
  background-color: #f1f1f1;
}

/* Side Menu Styling on the left */
.side-menu {
  position: fixed;
  top: 0;
  left: 0; /* Move to the left */
  width: 450px; /* Increase the width */
  height: 100%;
  background-color: #f8f9fa;
  box-shadow: 2px 0px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  overflow-y: auto;
  z-index: 1000;
}

/* Category search area styling */
.category-search input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  margin-bottom: 15px;
}

/* Close button on top of the side menu */
.close-btn {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
  position: absolute;
  top: 10px;
  right: 10px;
}

.close-btn:hover {
  background-color: #c82333;
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


