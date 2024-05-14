<template>
  <div class="product-area">
    <div class="accesories">
      <div class="side-indicator">
        <button class="btn" :class="{ 'active-btn': !selectedCategory }" type="button" @click="selectedCategory = null">
          All
        </button>
        <div v-for="category in categories" :key="category.id">
          <button class="btn" :class="{ 'active-btn': selectedCategory && selectedCategory.id === category.id }" type="button" @click="selectedCategory = category">
            {{ category.category_name }}
          </button>
        </div>
      </div>
      <div class="item-area">
        <div class="item-top-area top-area">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input id="monId" class="form-control" type="text" placeholder="Name or code or category" v-model="searchQuery">
          </div>

          <div class="edit-icon">
            <button class="btn fa-btn" type="button" data-toggle="modal" data-target="#addItemBox"><i class="fa fa-plus"></i></button>
          </div>
        </div>
        <div class="mob-btns">
          <button class="btn btn-green" type="button">Category</button>
          <button class="btn btn-green active-btn ml-auto float-right" type="button">Product</button>
        </div>
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
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import eventBus from './eventBus';

const products = ref([]);
const categories = ref([]);
const selectedCategory = ref(null);
const searchQuery = ref("");

const getProducts = () => {
  axios
    .get("/api/pos/products")
    .then((res) => {
      products.value = res.data;
    })
    .catch((error) => console.log(error));
};

const getCategories = () => {
  axios
    .get("/api/pos/categories")
    .then((res) => {
      categories.value = res.data;
    })
    .catch((error) => console.log(error));
};

onMounted(() => {
  getProducts();
  getCategories();
});
const addToCart = (product) => {
  axios
    .post("/pos/add-to-cart", {
      product_id: product.id,
      product_name: product.product_name,
      selling_price: product.selling_price
    })
    .then((response) => {
      // Handle the response if needed
      console.log(response.data.message);
      eventBus.emit('product-added');
    })
    .catch((error) => {
      // Handle the error if needed
      console.error(error);
    });
};


// Computed property to filter products by selected category
const filteredProducts = computed(() => {
  let filtered = products.value;

  if (selectedCategory.value) {
    filtered = filtered.filter((product) => product.category_id === selectedCategory.value.id);
  }

  const search = searchQuery.value.toLowerCase();

  return filtered.filter((product) => {
    const productName = product.product_name.toLowerCase();
    const productCode = product.product_code.toLowerCase();
    const categoryName = product.category?.category_name.toLowerCase() || "";

    return (
      productName.includes(search) ||
      productCode.includes(search) ||
      categoryName.includes(search)
    );
  });
});


</script>

<style scoped>
/* Add your component-specific styles here */
</style>
